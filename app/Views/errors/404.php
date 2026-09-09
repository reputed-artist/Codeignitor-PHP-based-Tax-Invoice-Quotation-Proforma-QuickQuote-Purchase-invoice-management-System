<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Page Not Found</title>
<!-- 
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

 -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arvo'>
<?= $this->include('include/links.php');?>
<style>
<?= file_get_contents(APPPATH . 'Views/errors/bootstrap.css'); ?>
</style>
<style>
<?= file_get_contents(APPPATH . 'Views/errors/style.css'); ?>
</style>
  </head>
    
  <body>
  <section class="page_404">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 ">
        <div class="col-sm-10 col-sm-offset-1  text-center">
          <div class="four_zero_four_bg">
            <h1 class="text-center ">404</h1>

          </div>

          <div class="contant_box_404">
            <h3 class="h2">
              Looks like you're lost
            </h3>

             <p>Oops! The page you're looking for does not exist.</p>
        <a class="link_404" href="<?= base_url(); ?>">Return to Home</a>
 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    
  </body>
  
  
</html>
