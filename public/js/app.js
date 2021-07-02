const requestApi = async()=>{
    const ORCID = document.getElementById('ORCID').value;
    const url = `https://pub.orcid.org/v3.0/${ORCID}`;
    const data = await fetch(url, {
        headers:{
            'content-type':'application/json'
        }
    });
    const jsonData = await data.json();

    const array = Object.values(jsonData.person);
    const nombre = array[1]['given-names']['value'];
    const apellido = array[1]['family-name']['value'];
    const keywords = array[7]['keyword'];
    let keyword=[];
    let email="";
    keywords.map((key) => {
        keyword = [...keyword, key.content]
    })
    const emails = array[5]['email'];
    emails.map((mail) => {
        if(mail.primary === true){
            email =mail.email
        }
    })
    document.getElementById('Name').value = nombre;
    document.getElementById('Lastname').value = apellido;
    document.getElementById('Keywords').value = keyword;
    document.getElementById('Email').value = email;
    document.getElementById('form').submit();
}

