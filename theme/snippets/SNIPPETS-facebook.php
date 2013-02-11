http://www.facebook.com/feeds/page.php?format=atom10&id=123909394333024

 <?php
		// Without this "ini_set" Facebook's RSS url is all screwy for reading!
		// This is the most essential line, don't forget it.
		ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
	 
		// This URL is the URL to the Facebook Page's RSS feed.
		// Go to the page's profile, and on the left-hand side click "Get Updates vis RSS"
		$rssUrl = "http://www.facebook.com/feeds/page.php?id=123909394333024&format=rss20";
		$xml = simplexml_load_file($rssUrl); // Load the XML file
	 
		// This creates an array called "entry" that puts each <item> in FB's
		// XML format into the array
		$entry = $xml->channel->item;
	 
		// This is just a blank string I create to add to as I loop through our
		// FB feed. Feel free to format however you want, or do whatever else
		// you want with the data.
		$returnMarkup = '';
	 
		// Now we'll loop through are array. I just have it going up to 3 items
		// for this example.
		for ($i = 0; $i < 2; $i++) {
			$returnMarkup .= "<h3>".$entry[$i]->title."</h3>"; // Title of the update
			//$returnMarkup .= "<p>".$entry[$i]->link."</p>"; // Link to the update
			$returnMarkup .= "<p>".$entry[$i]->description."</p>"; // Full content
			$returnMarkup .= "<p>".$entry[$i]->pubDate."</p>"; // The date published
			//$returnMarkup .= "<p>".$entry[$i]->author."</p>"; // The author (Page Title)
		}
	 
		// Finally, we return (or in this case echo) our formatted string with our
		// Facebook page feed data in it!
		echo $returnMarkup;
		?>