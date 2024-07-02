<?php


class ShowPartnerViewController extends BaseController{


    public function partners() : PartnersModel{
        return model("PartnersModel");
    }

    public function show($request){
        $idPartner = $request[0] ?? -1;
        $this->redirectWithBoolCondition(
            !$this->partners()->existsPartnerById($idPartner),
            "/aboutus",
            ['El partner seleccionado parece no existir'],
            "Notice"
        );
        view("partner", $this->partners()->getPartnerById($idPartner));
    }
}