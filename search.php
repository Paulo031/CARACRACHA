<?php
$servername = "localhost";
$username = "root";
$password = "pwcracha22";
$dbname_alunos = "bd_alunos";
$dbname_professores = "bd_professores";

$conn_alunos = new mysqli($servername, $username, $password, $dbname_alunos);

if ($conn_alunos->connect_error) {
    die("Conexão falhou: " . $conn_alunos->connect_error);
}

$conn_professores = new mysqli($servername, $username, $password, $dbname_professores);

if ($conn_professores->connect_error) {
    die("Conexão falhou: " . $conn_professores->connect_error);
}

if (isset($_POST['tipo_de_usuario']) && isset($_POST['termo_de_pesquisa'])) {
    $tipo_de_usuario = $conn_alunos->real_escape_string($_POST['tipo_de_usuario']);
    $termo_de_pesquisa = $conn_alunos->real_escape_string($_POST['termo_de_pesquisa']);

    if ($tipo_de_usuario === 'Aluno') {
        // Consulta SQL para pesquisar na tabela de alunos com base no termo de pesquisa
        $sql = "SELECT * FROM alunos WHERE nome LIKE '%$termo_de_pesquisa%' OR matricula LIKE '%$termo_de_pesquisa%' OR serie LIKE '%$termo_de_pesquisa%' OR cid_codigo LIKE '%$termo_de_pesquisa%'";
        $result = $conn_alunos->query($sql);
    } elseif ($tipo_de_usuario === 'Professor') {
        // Consulta SQL para pesquisar na tabela de professores com base no termo de pesquisa
        $sql = "SELECT * FROM professores WHERE nome LIKE '%$termo_de_pesquisa%' OR disciplina LIKE '%$termo_de_pesquisa%' OR area_formacao LIKE '%$termo_de_pesquisa%' OR cargo LIKE '%$termo_de_pesquisa%'";
        $result = $conn_professores->query($sql);
    } else {
        echo "Critério de pesquisa inválido.";
        exit;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Exibir os resultados da pesquisa de acordo com o tipo de usuário
            if ($tipo_de_usuario === 'Aluno') {
                // Exibir informações do aluno
                echo "<div class='cracha'>";
                echo "<img src='" . $row['foto'] . "' alt='Foto'>";
                echo "<p>Nome: " . $row['nome'] . "</p>";
                echo "<p>Série: " . $row['serie'] . "</p>";
                echo "<p>Matrícula: " . $row['matricula'] . "</p>";
               
                echo "</div>";
            } elseif ($tipo_de_usuario === 'Professor') {
                // Exibir informações do professor
                echo "<div class='cracha'>";
                echo "<img src='" . $row['foto'] . "' alt='Foto'>";
                echo "<p>Nome: " . $row['nome'] . "</p>";
                echo "<p>Matrícula: " . $row['matricula'] . "</p>";
                echo "<p>Cargo: " . $row['cargo'] . "</p>";
                echo "<p>Área de Formação: " . $row['area_formacao'] . "</p>";
                
                echo "</div>";
            }
        }
    } else {
        echo "Nenhum resultado encontrado.";
    }

    $conn_alunos->close();
    $conn_professores->close();
} else {
    echo "Parâmetros de pesquisa inválidos.";
}
?>