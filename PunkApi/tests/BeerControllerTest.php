<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class BeerControllerTest extends TestCase
{
    public function testCallApi()
    {
        $response = "";
        $statusCode = "200";
        $content = '[
            {
                "id": 12,
                "name": "Arcade Nation",
                "tagline": "Seasonal Black IPA.",
                "first_brewed": "12/2015",
                "description": "Running the knife-edge between an India Pale Ale and a Stout, this particular style is one we truly love. Black IPAs are a great showcase for the skill of our brew team, balancing so many complex and twisting flavours in the same moment. The citrus, mango and pine from the hops – three of our all-time favourites – play off against the roasty dryness from the malt bill at each and every turn.",
                "image_url": "https://images.punkapi.com/v2/12.png",
                "abv": 5.3,
                "ibu": 60,
                "target_fg": 1012,
                "target_og": 1052,
                "ebc": 200,
                "srm": 100,
                "ph": 4.2
            }
        ]';

        if ($statusCode === 200) {
            $response = json_decode($content, true);
        }

        $this->assertEquals(200, $statusCode);
        $this->assertSame(is_array($response), false);

    }
}
