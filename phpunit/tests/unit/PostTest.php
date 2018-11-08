<?php
use \PHPUnit\DbUnit\TestCaseTrait;

class PostTest extends \PHPUnit\Framework\TestCase {

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

	public function testSubmitPostSuccess() {
		$post = new \App\Models\Post($this->getConnection(), "homer_simpson");
		$post->submitPost("Hello", "homer_simpson");

		$details_array = $post->getSinglePost(7);

		$this->assertEquals($details_array['body'], "Hello");
		$this->assertEquals($details_array['added_by'], "homer_simpson");
	}

	public function testSubmitPostFailure() {
		$post = new \App\Models\Post($this->getConnection(), "homer_simpson");
		$post->submitPost("", "homer_simpson");

		$details_array = $post->getSinglePost(8);

		$this->assertArrayNotHasKey($details_array['body']);
		$this->assertArrayNotHasKey($details_array['added_by']);
	}