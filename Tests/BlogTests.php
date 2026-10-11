<?php declare(strict_types=1);
namespace Belin\Akismet;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\{Test, TestDox};

/**
 * Tests the features of the {@see Blog} class.
 */
#[TestDox("Blog")]
class BlogTests extends TestCase {

	#[Test, TestDox("jsonSerialize()")]
	public function jsonSerialize(): void {
		// It should return only the blog URL with a newly created instance.
		$json = new Blog("https://github.com/CedX/Akismet.php")->jsonSerialize();
		get_object_vars($json) |> count(...) |> Should::be(1);
		$json->blog |> Should::be("https://github.com/CedX/Akismet.php");

		// It should return a non-empty map with a initialized instance.
		$json = new Blog(charset: "UTF-8", languages: ["en", "fr"], url: "https://github.com/CedX/Akismet.php")->jsonSerialize();
		get_object_vars($json) |> count(...) |> Should::be(3);
		$json->blog |> Should::be("https://github.com/CedX/Akismet.php");
		$json->blog_charset |> Should::be("UTF-8");
		$json->blog_lang |> Should::be("en,fr");
	}
}
