const confirmDelete = (id, titulo) => {
    const confirm = window.confirm(`Tem certeza que deseja excluir o post ${titulo}?`);

    if(confirm){
        window.location.href = `excluir.php?id=${id}`;
    }
}