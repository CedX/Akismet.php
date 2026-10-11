<?php declare(strict_types=1);
namespace Belin\Akismet;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\{Test, TestDox};

/**
 * Tests the features of the {@see Author} class.
 */
#[TestDox("Author")]
class AuthorTests extends TestCase {

	#[Test, TestDox("jsonSerialize()")]
	public function jsonSerialize(): void {
		// It should return only the IP address with a newly created instance.
		$json = new Author(ipAddress: "127.0.0.1")->jsonSerialize();
		get_object_vars($json) |> count(...) |> Should::be(1);
		$json->user_ip |> Should::be("127.0.0.1");

		// It should return a non-empty map with a initialized instance.
		$json = new Author(
			email: "contact@cedric-belin.fr",
			ipAddress: "192.168.0.1",
			name: "Cédric Belin",
			url: "https://cedric-belin.fr",
			userAgent: "Mozilla/5.0"
		)->jsonSerialize();

		get_object_vars($json) |> count(...) |> Should::be(5);
		$json->comment_author |> Should::be("Cédric Belin");
		$json->comment_author_email |> Should::be("contact@cedric-belin.fr");
		$json->comment_author_url |> Should::be("https://cedric-belin.fr");
		$json->user_agent |> Should::be("Mozilla/5.0");
		$json->user_ip |> Should::be("192.168.0.1");
	}
}
