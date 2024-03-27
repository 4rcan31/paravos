<?php


class AboutusController extends BaseController{


    public function partners() : PartnersModel{
        return model("PartnersModel");
    }

    public function view(){
        view("aboutus", [
            "partners" => $this->partners()->get(),
            "maxcharacters" => $this->maxCharactersInDescriptionsCard()
        ]);
    }

    public function maxCharactersInDescriptionsCard() : int{
        return 75;
    }
}