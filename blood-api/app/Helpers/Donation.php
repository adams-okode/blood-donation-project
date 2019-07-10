<?php
namespace App\Helpers;

class Donation
{

    public static $bloodGroups = ['O-', 'O+', 'B-', 'B+', 'A-', 'A+', 'AB-', 'AB+'];
    public static $donationMatrix = [
        ['x', 'O-', 'O+', 'B-', 'B+', 'A-', 'A+', 'AB-', 'AB+'],
        ['AB+', 111, 111, 111, 111, 111, 111, 111, 111],
        ['AB-', 111, 000, 111, 000, 111, 000, 111, 000],
        ['A+', 111, 111, 000, 000, 111, 111, 000, 000],
        ['A-', 111, 000, 000, 000, 111, 000, 000, 000],
        ['B+', 111, 111, 111, 111, 000, 000, 000, 000],
        ['B-', 111, 000, 111, 000, 000, 000, 000, 000],
        ['O+', 111, 111, 000, 000, 000, 000, 000, 000],
        ['O-', 111, 000, 000, 000, 000, 000, 000, 000],
    ];

    public function __construct()
    {

    }

    /**
     * @param $bloodGroup
     */
    public static function findAllOneCanDonateTo(string $bloodGroup)
    {
        $bloodGroups = self::$donationMatrix;
        (int) $search = array_search($bloodGroup, self::$bloodGroups);
        if ($search === false) {
            /**
             * Throw Exception if bloodgroup not found
             */
            throw new \Exception("The blood Group Provided doesn't Exist", 500);
        }
        $acceptedRecipients = [];

        for ($i = 1; $i < 9; $i++) {
            $groupData = $bloodGroups[$i];
            if ($groupData[$search + 1] == 111) {
                $acceptedRecipients[] = $groupData[0];
            }
        }

        return $acceptedRecipients;
    }

    /**
     * @param $bloodGroup
     */
    public static function findAllOneCanReceiveFrom(string $bloodGroup)
    {
        $bloodGroups = self::$donationMatrix;
       
        (int) $search = array_search($bloodGroup, self::$bloodGroups);
        if ($search === false) {
            /**
             * Throw Exception if bloodgroup not found
             */
            throw new \Exception("The blood Group Provided doesn't Exist", 500);
        }

        $acceptedRecipients = [];
        $inverseNumber = abs($search - 8);

        $groupData = $bloodGroups[$inverseNumber];

        for ($i = 1; $i < 9; $i++) {
            if ($groupData[$i] == 111) {
                $acceptedRecipients[] = self::$bloodGroups[$i - 1];
            }
        }

        return $acceptedRecipients;
    }

}
