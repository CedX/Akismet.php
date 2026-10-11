<?php declare(strict_types=1);
namespace Belin\Akismet;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\{Test, TestDox};

/**
 * Tests the features of the {@see Comment} class.
 */
#[TestDox("Comment")]
class CommentTests extends TestCase {

	#[Test, TestDox("jsonSerialize()")]
	public function jsonSerialize(): void {
		// It should return only the author info with a newly created instance.
		$json = new Comment(author: new Author(ipAddress: "127.0.0.1"))->jsonSerialize();
		get_object_vars($json) |> count(...) |> Should::be(1);
		$json->user_ip |> Should::be("127.0.0.1");

		// It should return a non-empty map with a initialized instance.
		$json = new Comment(
			author: new Author(ipAddress: "127.0.0.1", name: "Cédric Belin", userAgent: "Doom/6.6.6"),
			content: "A user comment.",
			date: new \DateTime("2000-01-01T00:00:00.000Z"),
			referrer: "https://cedric-belin.fr",
			type: CommentType::BlogPost
		)->jsonSerialize();

		get_object_vars($json) |> count(...) |> Should::be(7);
		$json->comment_author |> Should::be("Cédric Belin");
		$json->comment_content |> Should::be("A user comment.");
		$json->comment_date_gmt |> Should::be("2000-01-01T00:00:00+00:00");
		$json->comment_type |> Should::be("blog-post");
		$json->referrer |> Should::be("https://cedric-belin.fr");
		$json->user_agent |> Should::be("Doom/6.6.6");
		$json->user_ip |> Should::be("127.0.0.1");
	}
}
