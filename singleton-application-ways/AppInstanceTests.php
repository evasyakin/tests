<?php

class AppInstanceTest
{
    public $app1;
    public $app2;
    public $app1name;
    public $app2name;

    public function __construct(string $app1name, string $app2name, array $actions)
    {
        $this->app1name = $app1name;
        $this->app2name = $app2name;
        $this->tableHeader();
        $this->infoLine();
        $this->app1 = new $app1name;
        $this->app2 = new $app2name;
        $this->action('init $app1name, $app2name');
        $this->actions($actions);
        $this->tableFooter();
    }

    public function actions(array $actions) {
        foreach ($actions as $msg => &$callback) {
            $this->action($msg, $callback);
        }
    }

    public function action(string $msg, callable $callback = null) {
        if (!empty($callback)) {
            $callback = $callback->bindTo($this);
            $callback();
        }
        echo "<tr class=\"action\"><td>Action:</td><td colspan=\"4\">$msg</td></th>";
        $this->infoLine();
    }

    public function infoLine() {
        $cells = [
            'Info:',
            $this->app1->name ?? null, $this->app1name::get('name'),
            $this->app2->name ?? null, $this->app2name::get('name'),
        ];
        echo "<tr class=\"info\"><td>". implode('</td><td>', $cells) .'</td></tr>';
    }

    public function unsetInstances()
    {
        $this->app1->unsetInstance();
        $this->app2->unsetInstance();
    }

    public function __destruct() {
        $this->unsetInstances();
    }


    public function tableHeader() {
        echo '<table><tr><td></td>
            <th>App1 name</th><th>App1 instance name</th>
            <th>App2 name</th><th>App2 instance name</th>
        </tr>';
    }
    public function tableFooter() {
        echo '</table>';
    }
}

class AppInstanceTests
{
    public function __construct(string ...$namespaces)
    {
        if (empty($namespaces)) $namespaces = [null];
        for ($i = 1; $i < 5; $i++) {
            echo "<div class=\"case\"><h2 class=\"case-title\">Кейс #{$i}</h2><div class=\"case-inner\">";
            foreach ($namespaces as &$namespace) {
                echo "<div class=\"namespace\"><h3 class=\"namespace-title\">{$namespace}</h3>";
                $test = new AppInstanceTest("{$namespace}\\App0", "{$namespace}\\App$i", [
                    'App1::set(\'name\', \'App1 instance\')' => function () {
                        $this->app1::set('name', 'App1 instance');
                    },
                    'App2::set(\'name\', \'App2 instance\')' => function () {
                        $this->app2::set('name', 'App2 instance');
                    },
                    '$app1->name = \'App1\'' => function () {
                        $this->app1->name = 'App1';
                    },
                    '$app2->name = \'App2\'' => function () {
                        $this->app2->name = 'App2';
                    },
                ]);
                unset($test);
                echo '</div>';
            }
            echo '</div></div>';
        }
    }
}

?>
<style type="text/css">
    h3 {margin-top: 10px; text-align: center;}
    * {box-sizing: border-box; margin: 0; padding: 0; vertical-align: top;}
    body {font-family: 'Open Sans'; font-size: 14px;}
    .case {margin: 10px auto; text-align: center;}
    .case-inner {display: flex; justify-content: center;}
    .namespace {}
    table {border-collapse: collapse; font-size: 13px; margin: 7px;}
    td, th {border: solid #ddd 1px; padding: 5px 7px;}
    th {background: #eee;}
    tr.info td:first-child {background: #eee;}
    tr.info td:nth-child(n+2) {background: #444; color: #fff; text-align: center;}
</style>
