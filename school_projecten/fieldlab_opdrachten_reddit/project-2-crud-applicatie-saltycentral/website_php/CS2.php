<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Document</title>
    <style>
        main {
            background-image: url('../images/CS2.png');
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>

    <link rel="stylesheet" href="../styling/style.css">
</head>
<body>
    <main>
<nav> <?php include('nav.php') ?></nav>
    <main class="container-fluid d-flex">
    <section id="content" class="content col-lg-8 col-md-8 col-sm-12 border border-2 rounded border-dark m-3 h-60 justify-content-center scrollable-section shadow-lg p-3 mb-5 bg-body-tertiary rounded">
    <?php
            include('cod_topics.php');
            ?>
            
        </section>
        <aside class="col-lg-2 col-md-2 col-sm-12 border border-2 rounded border-dark m-5 p-2 h-30 aside shadow-lg p-2 mb-5 bg-body-tertiary rounded">
            <?php
            include('aside.php');
            ?>
        </aside>
    </main>
        <footer class="footer mt-auto py-2 text-center sticky-bottom" style="background-color: #212529;">
        <?php include('footer.php') ?>
    </footer>
    
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- show the text of the topic-->
<script>
    function showModal(elementId) {
        var name = document.getElementById(elementId).innerText;
        document.querySelector('.modal-title').innerText = name;
    }
</script>
</html>