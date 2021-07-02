<?php

namespace App\Http\Controllers;

use App\Http\Resources\ORCID;
use App\Models\OrcidUser;
use DOMDocument;
use Illuminate\Http\Request;
use SimpleXMLElement;

use function GuzzleHttp\json_decode;

class OrcidApiController extends Controller
{
    public function create(Request $request)
    {
        $data = request()->all();
        try {
            OrcidUser::insert($data);
            return response()->json([
                'response'=>'Usuario creado con éxito',
                'status'=>200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'response'=>'Error al crear usuario',
                'status'=>400,
            ]);
        }
    }
    public function list(){
        $data['data'] = OrcidUser::orderby('id', 'desc')->paginate(2);
        $orcid = new ORCID($data);
        return response()->json(
            $orcid
        );
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($orcid)
    {
        $OrcidUsers = OrcidUser::where('ORCID',$orcid)->get();
        if($OrcidUsers == '[]'){
            $res = array(
                'Investigador' => 'Investigador no encontrado',
            );
            $res = array_flip($res);
            $xml = new SimpleXMLElement('<Investigadores/>');
            array_walk_recursive($res,array($xml, 'addChild'));
            $response = $xml->asXML();
            return response($response)->header('content-type','application/xml');
        }else{
            $doc = new DOMDocument();
            $doc->formatOutput=true;
            $investigadores = $doc->createElement('Investigadores');
            $doc->appendChild($investigadores);
            $res = array();
            $res[] = array(
                    'ORCID'=>$OrcidUsers[0]['ORCID'],
                    'Name'=>$OrcidUsers[0]['Name'],
                    'Lastname'=>$OrcidUsers[0]['Lastname'],
                    'Email'=>$OrcidUsers[0]['Email'],
                    'Keywords'=>$OrcidUsers[0]['Keywords'],
            );
            foreach ($res as $r) {
                $investigador=$doc->createElement('Investigador');

                $orcid=$doc->createElement('ORCID');
                $orcid->appendChild($doc->createTextNode($r['ORCID']));
                $investigador->appendChild($orcid);

                $Name=$doc->createElement('Name');
                $Name->appendChild($doc->createTextNode($r['Name']));
                $investigador->appendChild($Name);
                
                $Lastname=$doc->createElement('Lastname');
                $Lastname->appendChild($doc->createTextNode($r['Lastname']));
                $investigador->appendChild($Lastname);

                $Email=$doc->createElement('Email');
                $Email->appendChild($doc->createTextNode($r['Email']));
                $investigador->appendChild($Email);

                $Keywords=$doc->createElement('Keywords');
                $Keywords->appendChild($doc->createTextNode($r['Keywords']));
                $investigador->appendChild($Keywords);
                
                $investigadores->appendChild($investigador);
            }
            $data = $doc->saveXML();
            return response($data)->header('content-type', 'application/xml');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($orcid)
    {
        $OrcidUsers = OrcidUser::where('ORCID',$orcid)->get();
        if($OrcidUsers == '[]'){
            return response()->json([
                'response'=>'Orcid no encontrado',
                'status'=>400,
            ]);
        }else{
            OrcidUser::where('ORCID',$orcid)->delete();
            return response()->json([
                'response'=>'Usuario Eliminado con éxito',
                'status'=>200,
            ]);
        }
    }
}
/*
$OrcidUsers = OrcidUser::where('ORCID',$orcid)->get();
if($OrcidUsers == '[]'){
    $doc = new DOMDocument();
    $doc->formatOutput=true;
    $investigadores = $doc->createElement('Investigadores');
    $doc->appendChild($investigadores);
    $res = array();
    $res[] = array(
        "Response"=>"Investigador no encontrado",
    );
    foreach ($res as $r) {
        $response=$doc->createElement('Response');
        $response->appendChild($doc->createTextNode($r['Response']));
        $investigadores->appendChild($response);
    }
    $data = $doc->saveXML();
    return response($data)->header('content-type', 'application/xml');
}else{
    $doc = new DOMDocument();
    $doc->formatOutput=true;
    $investigadores = $doc->createElement('Investigadores');
    $doc->appendChild($investigadores);
    $res = array();
    $OrcidUsers;
    foreach ($res as $r) {
        $response=$doc->createElement('Response');
        $response->appendChild($doc->createTextNode($r['Response']));
        $investigadores->appendChild($response);
    }
    $data = $doc->saveXML();
    return response($data)->header('content-type', 'application/xml');
}
*/