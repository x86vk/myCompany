<?php
require_once(dirname(__FILE__).'/config.php');
class reportGenereator
{
    private $now_word = "";

    public function __construct()
    {
        $template = fopen(WebRoot."/reportTemplate.html", "r");
        $this->now_word = fread($template, filesize(WebRoot."/reportTemplate.html"));
        fclose($template);
    }

    public function init($report_title, $name, $time_start, $time_end, $report_name)
    {
        $this->now_word .= "<h1><a name='header-n3' class='md-header-anchor '></a>";
        $this->now_word .= $report_name;
        $this->now_word .= "</h1>";
        $this->now_word .= "<p><strong>";
        $this->now_word .= $name;
        $this->now_word .= "</strong>,您好：</p><p>这是您从<strong>";
        $this->now_word .= $time_start;
        $this->now_word .= "</strong>到<strong>";
        $this->now_word .= $time_end;
        $this->now_word .= "</strong>的<strong>";
        $this->now_word .= $report_name;
        $this->now_word .= "</strong>，请查阅：</p>";
    }

    public function init2($report_name)
    {
        $this->now_word .= "<h1><a name='header-n3' class='md-header-anchor '></a>";
        $this->now_word .= $report_name;
        $this->now_word .= "</h1>";
    }

    public function insert_table_head() {
        $this->now_word .= "<table><thead><tr>";
        for($i = 0; $i < func_num_args(); ++$i) {
            $this->now_word .= "<th>";
            $this->now_word .= func_get_arg($i);
            $this->now_word .= "</th>";
        }
        $this->now_word .= "</tr></thead><tbody>";
    }

    public function insert_table_col() {
        $this->now_word .= "<tr>";
        for($i = 0; $i < func_num_args(); ++$i) {
            $this->now_word .= "<td>";
            $this->now_word .= func_get_arg($i);
            $this->now_word .= "</td>";
        }
        $this->now_word .= "</tr>";
    }

    public function end_table($time, $words) {
        $this->now_word .= "</tbody></table><p>生成时间：<em>";
        $this->now_word .= $time;
        $this->now_word .= "</em></p><p>";
        $this->now_word .= $words;
        $this->now_word .= "</p></div></body></html><script type=\"text/javascript\">window.print()</script>";
    }

    public function output_html($path) {
        $file = fopen($path, "w");
        fwrite($file, $this->now_word);
        fclose($file);
    }
}
