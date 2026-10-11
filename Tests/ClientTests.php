<?php declare(strict_types=1);
namespace Belin\Akismet;

use PHPUnit\Framework\{Assert, TestCase};
use PHPUnit\Framework\Attributes\{Before, Test, TestDox};

/**
 * Tests the features of the {@see Client} class.
 */
#[TestDox("Client")]
class ClientTests extends TestCase {

	/**
	 * The client used to query the remote API.
	 */
	private Client $client;

	/**
	 * A comment with content marked as ham.
	 */
	private Comment $ham;

	/**
	 * A comment with content marked as spam.
	 */
	private Comment $spam;

	#[Test, TestDox("checkComment()")]
	public function checkComment(): void {
		// It should return `CheckResult::ham` for valid comment (e.g. ham).
		$this->client->checkComment($this->ham) |> Should::be(CheckResult::Ham);

		// It should return `CheckResult::spam` for invalid comment (e.g. spam).
		$this->client->checkComment($this->spam) |> Should::beOneOf([CheckResult::Spam, CheckResult::PervasiveSpam]);
	}

	#[Test, TestDox("submitHam()")]
	public function submitHam(): void {
		(fn() => $this->client->submitHam($this->ham)) |> Should::notThrow();
	}

	#[Test, TestDox("submitSpam()")]
	public function submitSpam(): void {
		(fn() => $this->client->submitSpam($this->spam)) |> Should::notThrow();
	}

	#[Test, TestDox("verifyKey()")]
	public function verifyKey(): void {
		// It should return `true` for a valid API key.
		$this->client->verifyKey() |> Should::beTrue();

		// It should return `false` for an invalid API key.
		$client = new Client(apiKey: "0123456789AB", blog: $this->client->blog, isTest: true);
		$client->verifyKey() |> Should::beFalse();
	}

	#[Before]
	protected function before(): void {
		$this->client = new Client(
			apiKey: getenv("AKISMET_API_KEY") ?: "",
			blog: new Blog("https://github.com/CedX/Akismet.php"),
			isTest: true
		);

		$this->ham = new Comment(
			author: new Author(
				ipAddress: "192.168.0.1",
				name: "Akismet",
				role: AuthorRole::Administrator,
				url: "https://cedric-belin.fr",
				userAgent: "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0"
			),
			content: "I'm testing out the Service API.",
			referrer: "https://www.npmjs.com/package/@cedx/akismet",
			type: CommentType::Comment
		);

		$this->spam = new Comment(
			author: new Author(
				email: "akismet-guaranteed-spam@example.com",
				ipAddress: "127.0.0.1",
				name: "viagra-test-123",
				userAgent: "Spam Bot/6.6.6"
			),
			content: "Spam!",
			type: CommentType::BlogPost
		);
	}
}
