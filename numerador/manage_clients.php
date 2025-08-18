<?php
// ===============================================
// SISTEMA DE AUTOMAÇÃO JURÍDICA - GESTÃO DE CLIENTES
// ===============================================

require_once('../Connections/conexao.php');

// Verificação de autenticação básica
session_start();
if (!isset($_SESSION['user_logged'])) {
    header("Location: ../logar/index.php");
    exit();
}

$editFormAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlspecialchars($_SERVER['QUERY_STRING']);
}

// ===============================================
// PROCESSAMENTO DE AÇÕES
// ===============================================

// Inserir novo cliente
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "add_client") {
    $insertSQL = sprintf("INSERT INTO legal_clients (client_name, client_type, document_number, email, phone, address, notes) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($conexao, $_POST['client_name'], "text"),
                       GetSQLValueString($conexao, $_POST['client_type'], "text"),
                       GetSQLValueString($conexao, $_POST['document_number'], "text"),
                       GetSQLValueString($conexao, $_POST['email'], "text"),
                       GetSQLValueString($conexao, $_POST['phone'], "text"),
                       GetSQLValueString($conexao, $_POST['address'], "text"),
                       GetSQLValueString($conexao, $_POST['notes'], "text"));

    $Result1 = mysqli_query($conexao, $insertSQL);

    if ($Result1) {
        $insertGoTo = "manage_clients.php?action=success";
        header(sprintf("Location: %s", $insertGoTo));
        exit();
    } else {
        $error_message = "Erro ao cadastrar cliente: " . mysqli_error($conexao);
    }
}

// Consultar clientes
$query_clients = "SELECT * FROM legal_clients WHERE status = 'ATIVO' ORDER BY client_name ASC";
$result_clients = mysqli_query($conexao, $query_clients);
$totalRows_clients = mysqli_num_rows($result_clients);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes - Sistema Jurídico</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #2c5530; color: white; padding: 15px; margin: -20px -20px 20px -20px; border-radius: 8px 8px 0 0; }
        .form-section { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .form-row { display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap; }
        .form-group { flex: 1; min-width: 200px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #1e7e34; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .table th { background: #f8f9fa; font-weight: bold; }
        .table tr:nth-child(even) { background: #f9f9f9; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .search-box { padding: 10px; border: 1px solid #ddd; border-radius: 4px; width: 300px; margin-bottom: 20px; }
    </style>
    <script>
        function searchClients() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("clientsTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var found = false;
                for (var j = 0; j < cells.length; j++) {
                    if (cells[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        }

        function validateForm() {
            var name = document.forms["clientForm"]["client_name"].value;
            var document = document.forms["clientForm"]["document_number"].value;
            
            if (name == "") {
                alert("Nome do cliente é obrigatório!");
                return false;
            }
            if (document == "") {
                alert("CPF/CNPJ é obrigatório!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏛️ Sistema de Automação Jurídica - Gestão de Clientes</h1>
        </div>

        <?php if (isset($_GET['action']) && $_GET['action'] == 'success'): ?>
            <div class="alert alert-success">
                ✅ Cliente cadastrado com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">
                ❌ <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Formulário de Cadastro -->
        <div class="form-section">
            <h2>📋 Cadastrar Novo Cliente</h2>
            <form name="clientForm" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return validateForm()">
                <div class="form-row">
                    <div class="form-group">
                        <label for="client_name">Nome Completo *</label>
                        <input type="text" name="client_name" id="client_name" required>
                    </div>
                    <div class="form-group">
                        <label for="client_type">Tipo de Pessoa *</label>
                        <select name="client_type" id="client_type">
                            <option value="PESSOA_FISICA">Pessoa Física</option>
                            <option value="PESSOA_JURIDICA">Pessoa Jurídica</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="document_number">CPF/CNPJ *</label>
                        <input type="text" name="document_number" id="document_number" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" name="phone" id="phone">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="address">Endereço Completo</label>
                        <textarea name="address" id="address" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="notes">Observações</label>
                        <textarea name="notes" id="notes" rows="3"></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">💾 Cadastrar Cliente</button>
                <input type="hidden" name="MM_insert" value="add_client">
            </form>
        </div>

        <!-- Lista de Clientes -->
        <div>
            <h2>👥 Clientes Cadastrados</h2>
            <input type="text" id="searchInput" class="search-box" placeholder="🔍 Buscar clientes..." onkeyup="searchClients()">
            
            <?php if ($totalRows_clients > 0): ?>
                <table class="table" id="clientsTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>CPF/CNPJ</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Cadastrado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_client = mysqli_fetch_assoc($result_clients)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row_client['client_name']); ?></td>
                            <td><?php echo $row_client['client_type'] == 'PESSOA_FISICA' ? 'PF' : 'PJ'; ?></td>
                            <td><?php echo htmlspecialchars($row_client['document_number']); ?></td>
                            <td><?php echo htmlspecialchars($row_client['email']); ?></td>
                            <td><?php echo htmlspecialchars($row_client['phone']); ?></td>
                            <td><?php echo Consert_DataBr(substr($row_client['created_date'], 0, 10)); ?></td>
                            <td>
                                <a href="client_profile.php?id=<?php echo $row_client['client_id']; ?>" class="btn" style="background: #17a2b8;">
                                    👤 Perfil
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info" style="background: #cce7ff; color: #004085; border: 1px solid #99d6ff;">
                    ℹ️ Nenhum cliente cadastrado ainda.
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="../numerador/pagina.php" class="btn">⬅️ Voltar ao Sistema Principal</a>
        </div>
    </div>
</body>
</html>

<?php
// Limpeza de recursos
if (isset($result_clients)) {
    mysqli_free_result($result_clients);
}
?>