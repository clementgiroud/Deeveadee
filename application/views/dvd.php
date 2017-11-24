<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dvd Admin</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>


  <div class="container">
    <h1>Deeveadee Store</h1>
</center>
    <h3>Espace Admin</h3>
    <br />
    <button class="btn btn-success" onclick="add_dvd()"><i class="glyphicon glyphicon-plus"></i>Ajouter un dvd</button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>
					<th>ID</th>
					<th>Titre</th>
					<th>Réalisateur</th>
					<th>Année</th>
					<th>Catégorie</th>

          <th style="width:125px;">Action
          </p></th>
        </tr>
      </thead>
      <tbody>
				<?php foreach($dvds as $dvd){?>
				     <tr>
				         <td><?php echo $dvd->id;?></td>
				         <td><?php echo $dvd->titreD;?></td>
								 <td><?php echo $dvd->auteurD;?></td>
								<td><?php echo $dvd->anneeD;?></td>
								<td><?php echo $dvd->categorieD;?></td>
								<td>
									<button class="btn btn-warning" onclick="edit_dvd(<?php echo $dvd->id;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
									<button class="btn btn-danger" onclick="delete_dvd(<?php echo $dvd->id;?>)"><i class="glyphicon glyphicon-remove"></i></button>


								</td>
				      </tr>
				     <?php }?>



      </tbody>

      <tfoot>
        <tr>
          <th>ID</th>
					<th>Titre</th>
					<th>Réalisateur</th>
					<th>Année</th>
					<th>Catégorie</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>

  </div>

  <script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>


  <script type="text/javascript">
  $(document).ready( function () {
      $('#table_id').DataTable({
          "language": {
              "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
          }
      });
  } );
    var save_method; //for save method string
    var table;


    function add_dvd()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Formulaire'); // Set Title to Bootstrap modal title
    }

    function edit_dvd(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('dvd/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="titreD"]').val(data.titreD);
            $('[name="auteurD"]').val(data.auteurD);
            $('[name="anneeD"]').val(data.anneeD);
            $('[name="categorieDcategorieD"]').val(data.categorieD);


            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Dvd'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }



    function save()
    {
      var url;
      if(save_method == 'add')
      {
          url = "<?php echo site_url('dvd/dvd_add')?>";
      }
      else
      {
        url = "<?php echo site_url('dvd/dvd_update')?>";
      }

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
              location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function delete_dvd(id)
    {
      if(confirm('Etes-vous sûr de vouloir supprimer?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('dvd/dvd_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

      }
    }

  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Formulaire</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Titre</label>
              <div class="col-md-9">
                <input name="titreD" placeholder="Titre" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Réalisateur</label>
              <div class="col-md-9">
                <input name="auteurD" placeholder="Réalisateur" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Année</label>
              <div class="col-md-9">
								<input name="anneeD" placeholder="Année" class="form-control" type="text">

              </div>
            </div>
						<div class="form-group">
							<label class="control-label col-md-3">Catégorie</label>
							<div class="col-md-9">
								<input name="categorieD" placeholder="Catégorie" class="form-control" type="text">

							</div>
						</div>

          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Enregistrer</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

  </body>
</html>
