<?php
use \PHPUnit\DbUnit\TestCaseTrait;

class UserTest extends \PHPUnit\Framework\TestCase {

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

	public function testThatWeCanGetTheUsername() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->getUsername(), "homer_simpson");
	}

	public function testThatWeCanGetTheNumPosts() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->getNumPosts(), 2);
	}

	public function testFullNameIsReturned() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->getFirstAndLastName(), "Homer Simpson");
	}

	public function testProfilePicIsReturned() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->getProfilePic(), "assets/images/profile_pics/homer_simpson40f5e55cafb51fa8d4ddc3f778be1268n.jpeg");
	}

	public function testFriendArrayIsReturned() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->getFriendArray(), ",marge_simpson,");
	}

	public function testIfIsClosedIsReturned() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->isClosed(), false);
	}

	public function testIsFriend() {
		$user = new \App\Models\User($this->getConnection(), "homer_simpson");

		$this->assertEquals($user->isFriend(marge_simpson), true);
	}
}