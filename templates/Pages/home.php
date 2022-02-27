<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        $connection = ConnectionManager::get($name);
        $connected = $connection->connect();
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;
$cakeDescription = '書籍管理システム';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'home']) ?>
    <?= $this->Html->script(['chart', 'vue']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <div class="container text-center">
            <h1>
                <a class="header-link" href="<?= $this->Url->build('/', ['action' => 'Pages']) ?>" rel="noopener">
                    <?= h($cakeDescription) ?>
                </a>
            </h1>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="column">
                        <h2 class="text-center">統計</h2>
                        <div class="chart">
                            
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="column">
                        <h2 class="navigation-btn text-center"><?= $this->Html->link('作者管理', ['action' => 'index', 'controller' => 'Authors'], ['class' => 'header-link']) ?></h2>
                    </div>
                    <div class="column">
                        <?php if (!$isAuthenticated): ?>
                            <h2 class="navigation-btn text-center"><?= $this->Html->link('管理者ログイン', ['action' => 'login', 'controller' => 'Users'], ['class' => 'header-link']) ?></h2>
                        <?php else: ?>
                            <h2 class="navigation-btn text-center"><?= $this->Html->link('ユーザ一覧', ['action' => 'index', 'controller' => 'Users'], ['class' => 'header-link']) ?></h2>
                        <?php endif; ?>
                    </div>
                    <div class="column">
                        <h2 class="navigation-btn text-center"><?= $this->Html->link('書籍管理', ['action' => 'index', 'controller' => 'Books'], ['class' => 'header-link']) ?></h2>
                    </div>
                    <?php Debugger::checkSecurityKeys(); ?>
                </div>
            </div>
        </div>
    </main>
    <script>
        const chartsUrl = '<?= $chartsUrl ?>';
        const chartElement = document.querySelector('.chart');
        const chartErrorParagraph = document.createElement('p');
        chartErrorParagraph.textContent = '今月のユーザ、書籍、作者のバーグラフ';
        chartErrorParagraph.classList.add('text-center');

        Vue.createApp({
            data() {
                return {
                    chartsData: null
                }
            },
            methods: {
                async renderChart() {
                    this.chartsData = null;
                    try {
                        while (chartElement.firstChild) {
                            chartElement.removeChild(chartElement.firstChild);
                        }
                        const res = await fetch(chartsUrl);
                        this.chartsData = (await res.json()).monthlyStats;
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(this.drawChart);
                    } catch (e) {
                        chartElement.appendChild(chartErrorParagraph);
                    }
                },
                async drawChart() {
                    const data = google.visualization.arrayToDataTable(this.chartsData);
                    const options = {
                        title: '今月の統計',
                        curveType: 'function',
                        legend: { position: 'bottom' }
                    };
                    const chart = new google.visualization
                        .LineChart(chartElement);
                    chart.draw(data, options);
                }
            },
            mounted() {
                this.renderChart();
            }
        }).mount('.chart');
    </script>
</body>
</html>
