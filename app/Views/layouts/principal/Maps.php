<?Php


function generateGoogleMapsURI($latitude, $longitude) {
    $uri = 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d484.30716723419266';
    $uri .= '!2d' . $longitude . '!3d' . $latitude . '!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2ssv!4v1711515406096!5m2!1ses-419!2ssv';
    return $uri;
}