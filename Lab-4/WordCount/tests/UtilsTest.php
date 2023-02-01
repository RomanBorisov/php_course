<?php

use PHPUnit\Framework\TestCase;

use function App\countUniqueWordsInText;


class UtilsTest extends TestCase
{
	public function test_calculateWordCount_twoUniqueWords_2()
	{
		$testString = "Hello world hello user!";

		self::assertEquals(countUniqueWordsInText($testString), 3);
	}

	public function test_calculateWordCount_oneUniqueWord_1()
	{
		$testString = "Hello hello HeLlO";

		self::assertEquals(countUniqueWordsInText($testString), 1);
	}

	public function test_calculateWordCount_oneUniqueWordInCyrillic_1()
	{
		$testString = "Привет привет ПрИвЕт";

		self::assertEquals(countUniqueWordsInText($testString), 1);
	}

	public function test_calculateWordCount_twoUniqueWordInCyrillic_2()
	{
		$testString = "Привет привет мир         МиР !МИР! .Мир. ?мир? ПрИвЕт ";
		self::assertEquals(countUniqueWordsInText($testString), 2);
	}

	public function test_calculateWordCount_specialSimbols_0()
	{
		$testString = "? ?? !! : :: . , ; , .. ) ( )) ) (( (( & --- - - - - --";

		self::assertEquals(countUniqueWordsInText($testString), 0);
	}

}
