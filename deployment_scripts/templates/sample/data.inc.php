<?php

// A short story about how you meet. Using HTML entities and HTML tags for formatting.
$front_page_story = "";

// The location that the wedding is taking place at.
$wedding_town = "";

// The date and time of the Wedding. (Ex: date - October 28th, 2018 |  time - 4:00PM)
$wedding_date = "";
$wedding_time = "";

// The name of the place the Wedding is located at.
$wedding_location_name = "";

// A Google Maps link to the wedding location for an iframe on the details page.
$wedding_gmaps_link  = "";

// binary value for if the Wedding and Reception are at the same location. (0 = no, they are at separate locations, 1 = yes, they are at the same location)
$wedding_reception_same_location = 0;

// Hotel Information
// Name of the Hotel
$hotel_name  = "";
// Town and State of the wedding (Ex: Dedham, MA)
$hotel_town  = "";
// A Google Maps link of the Hotel for an iframe on the details page.
$hotel_gmaps_link  = "";
// Link to the website of the hotel for your wedding for people to book rooms.
$hotel_room_link = "";

// The Information for the Day before Meet and Greet (Google Maps Link and a text blurb)
$meet_greet_gmaps_link = "";
$meet_greet_text = "";

// The Information for the morning after Brunch (Google Maps Link and a text blurb)
$brunch_gmaps_link = "";
$brunch_text = "";

// Reception Information (if different than the Wedding, if they are the same location, leave values blank)
// Name of the Place the reception is happening at
$reception_name  = "";
// Town the reception place is in
$reception_town  = "";
// Date and time of the reception
$reception_date  = "";
$reception_time  = "";
// A Google maps link to the reception place for an iframe on the details page.
$reception_gmaps_link  = "";

// The attire of the wedding and reception
$wedding_attire = "";
$reception_attire = "";

$main_page_image = ""; //Image that is on the Front page. Location is inside the /templates/<<tmpl folder name<>/imgs/ folder.

$registry_links =  array(
    0 => array(        // First Registry WebSite
        'link' => "",  // Link to the First
        'image' => ""  // name of the Registry website (located in the /templates/<<tmpl folder name<>/imgs/ folder.)
    ),
    1 => array(        // Optional, second registry website (add more and increment index number if necessary)
        'link' => "",
        'image' => ""
    )
);

// Photos and Descriptions for the Wedding Party Page.
$wedding_party_photos = array(
    // Relative URL path (ie /templates/imgs/person.jpg would then resolve to http://wedding.site.com/templates/imgs/person.jpg
    // Name of the Person
    // Their title in the Wedding Party
    array('/template/imgs/person.jpg','Person McPersonface','Best Person'),
    array('/template/imgs/person.jpg','Boaty McBoatface','Boat of Honor'),
);

// List of Photos of the couple for the Photos Page.
$couple_photos = array(
    // Relative URL path (ie /templates/imgs/photos/bride.jpg would then resolve to http://wedding.site.com/templates/imgs/photos/bride.jpg
    // Any Alt-text that you would like to have.
    array('/templates/imgs/photos/bride.jpg','The Bride in college.'),
    array('/templates/imgs/photos/groom.jpg','The Groom in college.'),
);