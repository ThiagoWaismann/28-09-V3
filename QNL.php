<!DOCTYPE html>
<html lang="en">
<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $nomeUsuario = $_SESSION['usuario'];
} else {
    header("Location: index.php");
    exit;
}
$nomeUsuario = $_SESSION['usuario'];

?>
<head>
    <meta charset="utf-8">
    <title>VISAO GERAL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
          rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet"/>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        table {
            border-collapse: separate;
            width: 90%;
            margin-bottom: 50px;
        }

        table, th, td {
            border: 4px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .vermelho {
            color: red;
        }

        .verde {
            color: green;
        }

        .amarelo {
            color: yellow;
        }

        .table-container {
            display: flex;
            flex-wrap: nowrap;
        }

        .table-column {
            flex-basis: calc(40% - 30px); 
            margin-right: 10px;
        }
    </style>
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">

    <!-- Spinner Start -->
    <!--div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div-->
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark">
            <a href="inicial.php" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"></i>KANBAN IA08</h3><br>
            </a>


            <a href="CSTBL.php" class="navbar-brand mx-4 mb-3">
                <h4 class="text-primary"></i> &#9500;HISTORICO</h4>
            </a>

            <a href="logout.php" class="navbar-brand mx-4 mb-3">
                <h4 class="text-primary"></i>&#9500;LOGOUT</h4>
            </a>

            <div class="d-flex align-items-center ms-4 mb-4"></div>
            <div class="navbar-nav w-100">

                <!--div class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i
                                class="far fa-file-alt me-2"></i>OPÇÕES</a>

                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="logout.php" class="dropdown-item active">LOGOUT</a>
                        <a href="CSTBL.php" class="dropdown-item active">CONSULTAR HISTORICO</a>
                    </div>
                </div-->
        </nav>
    </div>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">

        <!-- Navbar Start -->

        <!-- Navbar End -->

        <!-- Blank Start -->
        <div class="container-fluid pt-1 px-2">
            <div class="d-flex align-items-center justify-content-center bg-secondary rounde dp-4 p-sm-5 my-4 mx-3">
                <meta name="viewport" content="width=device-width, initial-scale=0.9">
                <img src="img/W2.png" alt="5">
            </div>

            <div class="row vh-200 bg-secondary rounded align-items-center justify-content-center mx-0">

                <div class="d-flex align-items-center justify-content-center">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">

                    <div class="col-md-40 justify-content-center  ">
                        <div class="col-md-40 justify-content-center">
                            <br>
                            
                            <h1 style="text-align: center;"><ul>QUADRO DE NIVELAMENTO</h1>

                            <hr style="border: 6px solid white;"><br><br>
                            <div class="col-md-40 justify-content-center  ">
                                <div class="table-container">
                                <?php
                                    $dbPath = 'OP.db';
                                    $conn = new SQLite3($dbPath);

                                    if (!$conn) {
                                        die("Conexão falhou: " . $conn->lastErrorMsg());
                                    }


                                    $tabelas = [
                                        'K7_512',
                                        'K7_507',
                                        'K9',
                                        'K7_511',
                                        'K11',
                                        'P7',
                                        'P5',
                                        'P3',
                                        'P2',
                                        'P1',
                                        'L7',
                                        'L6',
                                        'L5',
                                        'L4',
                                        'L3',
                                        'L2',
                                        'L1',
                                        'K1',
                                        'K2',
                                        'E1',
                                        'E10',
                                        'E2',
                                        'E3',
                                        'E4',
                                        'E5',
                                        'E6',
                                        'E7',
                                        'E8',
                                        'E9',
                                        'ES',
                                        'G',
                                        'G4',
                                        'K5',
                                        'KS',
                                        'LIM',
                                        'LIM1',
                                        'LIM2',
                                        'LIM3',
                                        'M1',
                                        'M13',
                                        'M2',
                                        'M3',
                                        'M4',
                                        'M54',
                                        'M59',
                                        'MAQ',
                                        'MS1',
                                        'PONTES',
                                        'PRENSA',
                                        'PS6',
                                        'PS7',
                                        'R1',
                                        'R2',
                                        'SG',
                                        'SU',
                                        'V1',
                                        'RS12',
                                        'K4',
                                        'K3',
                                        'IA08',
                                        'RS01',
                                    ];

                                    $colunas = [
                                        'QUANTIDADE', 
                                        'RS01',
                                        'IA08',
                                    ];
                                    
                                    foreach ($colunas as $coluna) {
                                        foreach ($tabelas as $tabela) {
                                            $tabelaSegura = $conn->escapeString($tabela);
                                    
                                            $query = "SELECT COUNT(*) AS total FROM $tabelaSegura";
                                            $result = $conn->query($query);
                                    
                                            if (!$result) {
                                                die("Erro na consulta da tabela $tabelaSegura: " . $conn->lastErrorMsg());
                                            }
                                    
                                            $row = $result->fetchArray(SQLITE3_ASSOC);
                                            $quantidade = $row['total'];
                                    
                                            $updateQuery = "UPDATE NIVELAMENTO SET $coluna = :quantidade WHERE LINHA = :tabela";
                                            $stmt = $conn->prepare($updateQuery);
                                            $stmt->bindValue(':quantidade', $quantidade, SQLITE3_INTEGER);
                                            $stmt->bindValue(':tabela', $tabelaSegura, SQLITE3_TEXT);
                                            
                                            $result = $stmt->execute();
                                    
                                            if (!$result) {
                                                die("Erro ao atualizar a coluna $coluna da tabela NIVELAMENTO para a linha $tabelaSegura: " . $conn->lastErrorMsg());
                                            }
                                        }
                                    }
                                    
                                    $conn->close();
                                    ?>
                                    <?php
                                        $dbPath = 'OP.db';
                                        $conn = new SQLite3($dbPath);

                                        if (!$conn) {
                                            die("Conexão falhou: " . $conn->lastErrorMsg());
                                        }

                                        $queryIA08 = "SELECT LINHA, COUNT(*) AS total FROM IA08 GROUP BY LINHA";
                                        $resultIA08 = $conn->query($queryIA08);

                                        if (!$resultIA08) {
                                            die("Erro na consulta da tabela IA08: " . $conn->lastErrorMsg());
                                        }

                                        $queryRS01 = "SELECT LINHA, COUNT(*) AS total FROM RS01 GROUP BY LINHA";
                                        $resultRS01 = $conn->query($queryRS01);

                                        if (!$resultRS01) {
                                            die("Erro na consulta da tabela RS01: " . $conn->lastErrorMsg());
                                        }

                                        while ($rowIA08 = $resultIA08->fetchArray(SQLITE3_ASSOC)) {
                                            $linhaIA08 = $rowIA08['LINHA'];
                                            $quantidadeIA08 = $rowIA08['total'];

                                            $updateQueryIA08 = "UPDATE NIVELAMENTO SET IA08 = :quantidadeIA08 WHERE LINHA = :linhaIA08";
                                            $stmtIA08 = $conn->prepare($updateQueryIA08);
                                            $stmtIA08->bindValue(':quantidadeIA08', $quantidadeIA08, SQLITE3_INTEGER);
                                            $stmtIA08->bindValue(':linhaIA08', $linhaIA08, SQLITE3_TEXT);

                                            $resultUpdateIA08 = $stmtIA08->execute();

                                            if (!$resultUpdateIA08) {
                                                die("Erro ao atualizar a coluna IA08 da tabela NIVELAMENTO para a linha $linhaIA08: " . $conn->lastErrorMsg());
                                            }
                                        }

                                        while ($rowRS01 = $resultRS01->fetchArray(SQLITE3_ASSOC)) {
                                            $linhaRS01 = $rowRS01['LINHA'];
                                            $quantidadeRS01 = $rowRS01['total'];

                                            $updateQueryRS01 = "UPDATE NIVELAMENTO SET RS01 = :quantidadeRS01 WHERE LINHA = :linhaRS01";
                                            $stmtRS01 = $conn->prepare($updateQueryRS01);
                                            $stmtRS01->bindValue(':quantidadeRS01', $quantidadeRS01, SQLITE3_INTEGER);
                                            $stmtRS01->bindValue(':linhaRS01', $linhaRS01, SQLITE3_TEXT);

                                            $resultUpdateRS01 = $stmtRS01->execute();

                                            if (!$resultUpdateRS01) {
                                                die("Erro ao atualizar a coluna RS01 da tabela NIVELAMENTO para a linha $linhaRS01: " . $conn->lastErrorMsg());
                                            }
                                        }

                                        $conn->close();
                                        ?>
                                         
                                                    <?php
                                                    $dbPath = 'OP.db';
                                                    $conn = new SQLite3($dbPath);

                                                    if (!$conn) {
                                                        die("Conexão falhou: " . $conn->lastErrorMsg());
                                                    }

                                                    $query = "SELECT LINHA, QUANTIDADE, RS01, IA08 FROM NIVELAMENTO";
                                                    $result = $conn->query($query);

                                                    if (!$result) {
                                                        die("Erro na consulta: " . $conn->lastErrorMsg());
                                                    }

                                                    $linhaCount = 0;

                                                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                                        $linha = $row['LINHA'];
                                                        $quantidade = $row['QUANTIDADE'];

                                                        if ($quantidade >= 10) {
                                                            $corClasse = 'verde';
                                                        } elseif ($quantidade > 4) {
                                                            $corClasse = 'amarelo';
                                                        } else {
                                                            $corClasse = 'vermelho';
                                                        }

                                                        if ($linhaCount % 15 === 0) {
                                                            echo "<div class='table-column'>";
                                                            echo "<table>";
                                                            echo "<tr><th>LINHA</th><th>QUANTIDADE NA LINHA</th><th>IA08</th><th>RS01</th></tr>";
                                                        }

                                                        echo "<tr>";
                                                        echo "<td class='$corClasse'>$linha</td>";
                                                        echo "<td>{$row['QUANTIDADE']}</td>";
                                                        echo "<td>{$row['IA08']}</td>";
                                                        echo "<td>{$row['RS01']}</td>";
                                                        echo "</tr>";

                                                        $linhaCount++;

                                                        if ($linhaCount % 15 === 0) {
                                                            echo "</table>";
                                                            echo "</div>";
                                                        }
                                                    }

                                                    $conn->close();
                                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blank End -->
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/chart/chart.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/tempusdominus/js/moment.min.js"></script>
<script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!--Javascript -->
<script src="js/main.js"></script>
</body>

</html>
