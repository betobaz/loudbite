<?php
class ArtistController extends Zend_Controller_Action
{
    /**
     * Add an artist to the database
     */
    public function newAction()
    {    
        //Check if the user is logged in
        //Set the view variables
        $this->view->form = $this->getAddArtistForm();
    }

    /**
     * List all the artists in the system.
     *
     */
    public function listAllArtistsAction()
    {

    }
    /**
     * Artist Items a user might be interested
     * in purchasing.
     *
     */
    public function artistaffiliatecontentAction()
    {
        
    }

    /**
     * Artist Profile
     *
     */
    public function profileAction()
    {
        
    }

    /**
     * Save the Artist entered by the user.
     */
    public function saveArtistAction(){

        //Initialize variables
        $artistName = $this->_request->getPost('artistName');
        $genre = $this->_request->getPost('genre');
        $rating = $this->_request->getPost('rating');
        $isFav = $this->_request->getPost('isFav');

        //Set new escape function to use
        require "utils/Escape.php";
        $escapeObj = new Escape();
        $this->view->setEscape(array($escapeObj, "doEnhancedEscape"));
        //Clean up inputs
        $artistName = $this->view->escape($artistName);
        $genre = $this->view->escape($genre);
        $rating = $this->view->escape($rating);
        $isFav = $this->view->escape($isFav);

        //Save the input in to the BD

    }

    /**
     * Display news for users artis
     */
    public function newsAction()
    {
        //Check if the user is logged in

        //Get the user's Id

        //Get the artist. (Example uses static artists)
        $artist = array(
            "Thievery Corporation",
            "The Eagles",
            "Elton John"
        );

        //Set the view variables
        $this->view->artist = $artist;

        //Find the view in our new location
        $this->view->setScriptPath("/var/www/");
        $this->render("news");
    }

    /**
     * Remove favorite artist..
     */
    public function removeAction()
    {
        //Check if the user is logged in

        //Get the user's Id

        //Get the user's artist.
        $artists = array(
            array("name"=>"Thievery Corporation","rating"=>5),
            array("name"=>"The Eagles","rating"=>5),
            array("name"=>"Elton John","rating"=>4)
        );

        //Set the total number of artists in the array
        //Demostrates the use of a key-value array assignment
        $totalNumberOfArtists = array("totalArtist"=>count($artist));
        
        //Set the view variables
        $this->view->assign("artists",$artists);
        $this->view->assign($totalNumberOfArtists);

    }

    /**
     * Create Add Artist Form
     *
     * @return Zend_Form
     */
    private function getAddArtistForm()
    {
        $form = new Zend_Form();
        $form->setAction("saveartist");
        $form->setMethod("post");
        $form->setName("addartist");

        //Create artist name
        $artistNameElement = new Zend_Form_Element_Text('artistName');
        $artistNameElement->setLabel("Artist Name:");

        //Create genres select menu
        $genres = array(
            "multiOptions"=>array(
                "electronic"=>"Electronic",
                "country"=>"Country",
                "rock"=>"Rock",
                "r_n_b"=>"R & B",
                "hip_hop"=>"Hip-Hop",
                "heavy_metal"=>"Heavy-Metal",
                "alternative_rock"=>"Alternative Rock",
                "christian"=>"Christian",
                "jazz"=>"Jazz",
                "pop"=>"Pop"
            )
        );
        $genreElement = new Zend_Form_Element_Select('genre',$genres);
        $genreElement->setLabel("Genre:");
        $genreElement->setRequired(true);

        //Create favorite radio buttons.
        $favoriteOptions = array(
            "multiOptions"=>array(
                "1"=>"yes",
                "0"=>"no"
            )
        );

        $isFavoriteListElement = new Zend_Form_Element_Radio('isFavorite',$favoriteOptions);
        $isFavoriteListElement->setLabel("Add to Favorite List:");
        $isFavoriteListElement->setRequired(true);

        //Create Rating radio button
        $ratingOptions = array(
          "multiOptions"=>array(
              "1"=>"1",
              "2"=>"2",
              "3"=>"3",
              "4"=>"4",
              "5"=>"5"
          )
        );

        $ratingElement = new Zend_Form_Element_Radio('rating',$ratingOptions);
        $ratingElement->setLabel("Rating:");
        $ratingElement->setRequired(true)->addValidator(new Zend_Validate_Alnum(false));

        //Create submit button
        $submitButton = new Zend_Form_Element_Submit("submit");
        $submitButton->setLabel("Add Artist");

        $form->addElement($artistNameElement);
        $form->addElement($genreElement);
        $form->addElement($isFavoriteListElement);
        $form->addElement($ratingElement);
        $form->addElement($submitButton);

        return $form;
    }
}

