function addDynamicSearch() {
    var tipo_de_usuario = document.querySelector(".dropdown-content a.selected").textContent;
    var dynamicSearch = document.getElementById("dynamicSearch");

    if (tipo_de_usuario === "Aluno") {
        dynamicSearch.innerHTML = '<br><label for="termo_de_pesquisa">Critério:</label><br><select id="criterio"><option value="">Escolha um critério</option><option value="nome">Nome</option><option value="turma">Turma</option><option value="cid">CID</option></select><br><label for="info">Informação:</label><br><input type="text" id="info"><br><button onclick="search()">Pesquisar</button>';
    } else if (tipo_de_usuario === "Professor") {
        dynamicSearch.innerHTML = '<br><label for="termo_de_pesquisa">Critério:</label><br><select id="criterio"><option value="">Escolha um critério</option><option value="disciplina">Disciplina</option><option value="area_formacao">Área</option><option value="cargo">Cargo</option></select><br><label for="info">Informação:</label><br><input type="text" id="info"><br><button onclick="search()">Pesquisar</button>';
    }
}

function search() {
    var category = document.querySelector(".dropdown-content a.selected").textContent;
    var info = document.getElementById("info").value;
    
    // Enviar dados para o servidor PHP usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "search.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Manipular a resposta do servidor, se necessário
            console.log(xhr.responseText);
        }
    };

    // Montar os dados a serem enviados
    var data = "tipo_de_usuario=" + encodeURIComponent(category) + "&termo_de_pesquisa=" + encodeURIComponent(info);
    xhr.send(data);
}

var dropdownItems = document.querySelectorAll(".dropdown-content a");
for (var i = 0; i < dropdownItems.length; i++) {
    dropdownItems[i].addEventListener("click", function () {
        var selectedItem = document.querySelector(".dropdown-content a.selected");
        if (selectedItem) {
            selectedItem.classList.remove("selected");
        }
        this.classList.add("selected");
        addDynamicSearch();
    });
}
