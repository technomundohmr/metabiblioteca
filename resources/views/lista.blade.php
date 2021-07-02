<div class="table-responsive">
    <table class="table table-hover text-center table-bordered">
        <thead>
            <tr class="table-success">
                <th>ORCID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Keywords</th>
                <th>Email</th>
                <th>Ver</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody id="cuerpoLista">
            @foreach ($items['data']['data'] as $item)
                <tr>
                    <td>{{$item['ORCID']}}</td>
                    <td>{{$item['Name']}}</td>
                    <td>{{$item['Lastname']}}</td>
                    <td>{{$item['Keywords']}}</td>
                    <td>{{$item['Email']}}</td>
                    <td>
                        <button class="btn btn-warning"><a class="text-decoration-none" href="http://localhost/metabiblioteca-rest/public/api/orcid/{{$item['ORCID']}}">Ver</a></button>
                    </td>
                    <td>
                        <form action="http://localhost/metabiblioteca-rest/public/api/orcid/{{$item['ORCID']}}" method="post">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>