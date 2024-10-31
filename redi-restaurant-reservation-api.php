<?php
trait ReDiAPIHelperMethods
{
    public function get_all_places()
    {
        if ($this->ApiKey == null) {

            $errors['Error'] = array(
                __(
                    'ReDi Restaurant Reservation plugin not registered'
                )
            );
            $this->display_errors($errors, true, 'Not registered');
            die;
        }

        $cached_places = get_transient('redi_restaurant_places');

        // If cached data exists, return it
        if ($cached_places !== false) {
            return $cached_places;
        }

        $places = $this->redi->getPlaces();

        if (isset ($places['Error'])) {
            $this->display_errors($places, true, 'getPlaces');
            die;
        }

        // Extracting only id, name, and address fields from each place
        $filteredPlaces = array();
        foreach ($places as $place) {
            $filteredPlaces[] = array(
                'id' => $place->ID,
                'name' => $place->Name,
                'address' => $place->Address
            );
        }

        set_transient('redi_restaurant_places', $filteredPlaces, HOUR_IN_SECONDS);

        return $filteredPlaces;
    }
}