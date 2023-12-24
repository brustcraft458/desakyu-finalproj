<?php
class Chart {
    public static $count_id = 0;

    static private function generateId() {
        self::$count_id++;
        return self::$count_id;
    }

    static private function chartjsWrapper($type, $data) {
        $id = self::generateID();
        $id = "chartElement$id";

        // Data
        $dKey = [];
        $dValue = [];

        foreach ($data as $key => $value) {
            array_push($dKey, $key);
            array_push($dValue, $value);
        }

        // Script
        $dKey = json_encode($dKey);
        $dValue = json_encode($dValue);

        $script = <<<EOT
            new Chart(document.getElementById('$id'), {
                type: '$type',
                data: {
                    labels: $dKey,
                    datasets: [{
                        data: $dValue
                    }],
                },
                options: {
                    maintainAspectRatio: false
                }
            });
        EOT;

        return [
            'id' => $id,
            'script' => $script
        ];
    }

    static public function pie($title, $desc, $data) {
        $res = self::chartjsWrapper("pie", $data);
        return chartjsElement($res['id'], $title, $desc, $res['script']);
    }

    static public function bar($title, $desc, $data) {
        $res = self::chartjsWrapper("bar", $data);
        return chartjsElement($res['id'], $title, $desc, $res['script']);
    }

    static public function progress($title, $data) {
        return progressElement($title, $data);
    }
}
?>

<!-- ChartJS -->
<?php function chartjsElement($id, $title, $desc, $script) {?>
    <div class="col-xl-4 col-lg-5" style="width: 20em; height: max-content">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="<?= $id ?>" style="width: 15em; height: 15em"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i><?= $desc ?>
                    </span>
                </div>
            </div>
        </div>

        <script><?= $script ?></script>
    </div>
<?php } ?>


<!-- Proggress Bar -->
<?php function progressElement($title, $data) {?>
    <div class="card shadow mb-4" style="width: 15em; height: max-content">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
        </div>
        <div class="card-body">
            <?php foreach ($data as $key => $value) : ?>
                <h4 class="small font-weight-bold"><?= $key ?><span class="float-right"> <?= $value ?>%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $value ?>%" aria-valuenow="<?= $value ?>"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php }?>