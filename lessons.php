<?php 
require_once('includes/header.php');

$units = $user->getUnits();
?>

<div id="container-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" color="black">Available Units</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-center" color="black">Please choose a unit to study below</5>
            </div>
        </div>
        <div class="row align-items-center">
            <?php
            foreach($units as $u) {
                try { //TODO: rather then query multiple times, create 1 query for all
                    $stmt = $db->prepare('SELECT f.file_name, f.loc_name FROM files f LEFT JOIN unit u ON u.unit_img=f.id WHERE u.id= :unitID ;');
                    $stmt->execute(array(
                        'unitID'  =>  $u['id']
                    ));
                    $unitImg = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
                if(empty($unitImg) || $unitImg == null) {
                    $unitImg['file_name'] = 'Temporary Filler';
                    $unitImg['loc_name'] = '../assets/icons/filler.svg';
                }
                if($u['published'] == 1) {
                    echo '
                    <div class="col-sm">
                    <a href="unit.php?name=' . $u['name'] . '">
                    <figure class="figure unit-link">
                    <img src="uploads/' . $unitImg['loc_name'] . '" class="figure-img img-fluid rounded" alt="' . $unitImg['file_name'] . '" unselectable="on" width="207" height="241">
                    <figcaption class="figure-caption text-center font-weight-bold">' . ucfirst($u['name']) . '</figcaption>
                    </figure>
                    </a>
                    </div>
                    ';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>
