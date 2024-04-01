<?php
layout("principal/Modal");


class Profile{

    private object $user;
    private object $orders;
    private string $html = "";

    public function __construct(array $data){
        $this->user = $data['user'];
        $this->orders = arrayToObject($data['orders']);
    }



    public function emailCard(){
        $this->card("Email", $this->user->email, false);
    }

    
    public function name(){
        $this->card("Nombre", $this->user->name, true, route("/api/v1/updateName", false), [
            [
                "label" => "Editar Nombre",
                "name" => "name"
            ]
        ]);
    }

    public function user(){
        $this->card("Usuario", $this->user->user, true, route("/api/v1/updateUser", false), [
            [
                "label" => "Editar usuario",
                "name" => "user"
            ]
        ]);
    }

    public function createAcount(){
        $this->card("Fecha y hora creacion de la cuenta", $this->user->created_at, false);
    }

    public function numOrders(){
        $this->card("Numero de ordenes creadas", $this->orders->count, false);
    }
    /* 
    
        [
            [
                type => text, (default text)
                label => "titulo"
                name => nameSend,
                value => valueOptional, (default "")

            ]
        ]
    */
    public function card(string $title, string $content, bool $edit = true, string $actionUrl = "", array $formInputs = []) {
        $modal = null;
        $html = '';
        if ($edit) {
            $modal = new Modal($title, $actionUrl);
            $form = '';
    
            foreach ($formInputs as $input) {
                $value = $input['value'] ?? "";
                $type = $input['type'] ?? 'text';
                $form .= ($type == "textarea") ?
                    $modal->textarea($input['label'], $input['name'], $value) :
                    $modal->input($input['label'], $input['name'], $value, $type);
            }
    
            $modal->setHtmlToRender($form);
            $idButton = $modal->getId();
    
            $html .= '<div class="mb-6 border border-gray-300 rounded p-4">
                <div class="flex justify-between flex-wrap gap-2 w-full">
                    <span class="text-gray-700 font-bold">' . $title . '</span>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm py-1 px-2 rounded" data-bs-toggle="modal" data-bs-target="#'.$idButton.'">
                        Editar
                    </button>
                </div>
                <p class="mt-1">' . $content . '</p>
            </div>';
        } else {
            $html .= '<div class="mb-6 border border-gray-300 rounded p-4">
                <div class="flex justify-between flex-wrap gap-2 w-full">
                    <span class="text-gray-700 font-bold">' . $title . '</span>
                </div>
                <p class="mt-1">' . $content . '</p>
            </div>';
        }
        
        //considerar que es mejor, si primero el modal o el html
        $modal = $modal == null ? "" : $modal->get();
        $this->html .= $html.$modal;
    }
    
    public function get() : string{
        return $this->html;
    }

    public function render() : void{
        echo $this->get();
    }
}