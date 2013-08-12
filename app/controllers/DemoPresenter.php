<?php

	class DemoPresenter extends Presenter {
		
		public function __construct() {
			$this->protected_actions = array("edit", "delete", "add");
		}

		public function index() {
			$data = array("name" => "Jakob Bossek", "profession" => "Webworker");
			$sub_view = View::make("app/views/demo.embed.tpl.php", $data);
			View::make("app/views/demo.tpl.php", $data)->assign("website", "www.jakobbossek.de/")->embed("test", $sub_view)->show();
			return;

			echo "Entering DemoPresenter<br>";
			echo Form::open("user/edit", "POST", true, array("name" => "test_form_name", "id" => "test_form_id")) . "<br>";
			echo Form::select(array(
				"Names with A" => array("Anna" => "1", "Alfred" => "2", "Anton" => "3"),
				"Names with B" => array("Bernd" => "4", "Berta" => "5", "Banana-Joe" => "6")),
			"2:2", 8, true, array("name" => "names", "id" => "names")) . "<br>";

			echo Form::select(array("Anna" => "1", "Alfred" => "2", "Anton" => "3"),
			3, 1, false, array("name" => "tesomat", "id" => "test")) . "<br>";

			echo Form::text(array("maxlength" => 30, "value" => "Max Mustermann", "options" => array("id" => "name")));

			echo Form::password(array("value" => "secret", "options" => array("id" => "name")));

			echo Form::close();

			// $l = new LinkedList();
			// $l->append(new ListElement("1"));
			// $l->append(new ListElement("2"));
			// $l->append(new ListElement("3"))->prepend(new ListElement("5"));
			// $l->showList();
			// $l->append_array(array(new ListElement("10"), "19"));
			// $l->showList();

			// $l2 = new LinkedList(new ListElement("200"));
			// $l->concat($l2)->showList();

			// echo "<br>STACKS</br>";
			// $s = new Stack(array(1,2,3,5));
			// $s->show();
			// $s->push(4);
			// $s->show();
			// $s->top();
			// $s->show();
			// $s->pop();
			// $s->show();
			// $s->pop();
			// $s->show();
			// die();

			// $source = "Hallo Welt";
			// echo (int) starts_with($source, $source);
			// echo (int) starts_with($source, "hallo", true);
			// echo (int) starts_with($source, "hallo", false) . "<br>";
			// echo (int) ends_with($source, $source);
			// echo (int) ends_with($source, $source.$source);
			// echo (int) ends_with($source, "Welt", true);
			// echo (int) ends_with($source, "Welt", false) . "<br>";
			// echo (int) contains($source, "hallo");
			// echo (int) contains($source, "hallo", false);
			// echo (int) contains($source, "o Wel");
			// echo (int) contains($source, $source) . "<br>";

			// echo "<br>";
			// echo to_camel("i_am_a_very_long_string_SEPeRAted_by_UNDERlines") . "<br>";
			// echo to_camel("") . "<br>";

			// echo "<br>";
			// echo camelize("I want to be camelized!") . "<br>";

			// init logger object
			// $logger = new Logger();
			// // define writer, which saves logs in a spefific way
			// $simpleWriter = new Logger_LoggerSimpleFileWriter("logs/logfile.csv");
			// $niceWriter = new Logger_LoggerSimpleFileWriter("logs/logfile.txt");
			// // the formatter defines the Format of the Log messages
			// $simpleFormatter = new Logger_LoggerSimpleFormatter();
			// $niceFormatter = new Logger_LoggerNiceFormatter();
			// $simpleWriter->setFormatter($simpleFormatter);
			// $niceWriter->setFormatter($niceFormatter);

			// $logger->addWriter("file_logger", $simpleWriter);
			// $logger->addWriter("file_logger_2", $niceWriter);
			// $logger->log("test_message", Logger::INFO);
		}
	}

?>