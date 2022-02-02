<?php
    include_once("conexao.php");   
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <title>Relatório de quantidade de produtos em categorias</title>
  </head>
  <body>
  <div class="container">
        <div class="m-5">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th><center>ID</center></th>                
                        <th>Categoria</th>
                        <th><center>Quantidade</center></th>
                    </tr>
                </thead>
                <tbody>            
                    <?php
                        $sql = "select c.id as categoriaID,
                                       c.name as categoria, 
                                       (select sum(coalesce(opr.units_sold, 0))
                                          from orders_products opr
                                         where opr.order_id = o.id  ) as Qtd
                                  from orders o
                                  inner join orders_products op on(o.id = op.order_id)
                                  inner join products p1 on (op.product_id = p1.id)
                                  inner join categories c on (p1.id_categories = c.id)
                                  /*where UPPER(o.status) = 'FINISH'*/
                                 order by op.units_sold desc
                                 limit 4";
                        $result =  $conn->query($sql);
                        if(!empty($result)){
                            foreach($result as $row) {
                                $row = (object)$row;

                                echo "<tr><td><center>".$row->categoriaID."</center></td>".
                                        "<td>".$row->categoria."</td>".
                                        "<td><center>".$row->Qtd."</center></td>".
                                        "</tr>";
                            }
                        }                                    
                    ?>                                         
                </tbody>
                <tfoot>
                    <tr>                
                        <th><center>ID</center></th>                                
                        <th>Categoria</th>
                        <th><center>Quantidade</center></th>
                    </tr>
                </tfoot>
            </table> 
      </div>
    </div>             

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(document).ready( function () {
    $('#example').DataTable();
} );
   </script>
</body>
</html>
