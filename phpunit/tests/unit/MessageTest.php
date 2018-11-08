<?php
use \PHPUnit\DbUnit\TestCaseTrait;

class MessageTest extends \PHPUnit\Framework\TestCase {

	static private $pdo = null;

	private $con = null;

	final public function getConnection() {
		if ($this->con === null) {
			if (self::$pdo == null) {
				self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
			}
			$this->con = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
		}

		return $this->con;
	}

	public function testSendMessageSuccess() {
		$message = new \App\Models\Message($this->getConnection(), "homer_simpson");
		$message->sendMessage("marge_simpson", "Hello", date("Y-m-d H:i:s"));

		$details_array = $message->getLatestMessage("homer_simpson", "marge_simpson");

		$this->assertEquals($details_array['sent_by'], "homer_simpson");
		$this->assertEquals($details_array['body'], "Hello");
	}

	public function testSendMessageFailure() {
		$message = new \App\Models\Message($this->getConnection(), "homer_simpson");
		$message->sendMessage("marge_simpson", "", date("Y-m-d H:i:s"));

		$details_array = $message->getLatestMessage("homer_simpson", "marge_simpson");

		$this->assertEquals($details_array['sent_by'], "homer_simpson");
		$this->assertEquals($details_array['body'], "");
	}