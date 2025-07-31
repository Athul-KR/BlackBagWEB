<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('ref_states')->truncate();
        DB::table('ref_states')->insert([
            ['state_prefix' => 'Alabama','state_name' => 'AL', 'sort_order' => '1' ],
            ['state_prefix' => 'Alaska','state_name' => 'AK', 'sort_order' => '2'  ],
            ['state_prefix' => 'Arizona','state_name' => 'AZ', 'sort_order' => '3' ],
            ['state_prefix' => 'Arkansas','state_name' => 'AR', 'sort_order' => '4'],
            ['state_prefix' => 'California','state_name' => 'CA', 'sort_order' => '5' ],
            ['state_prefix' => 'Colorado','state_name' => 'CO', 'sort_order' => '6' ],
            ['state_prefix' => 'Connecticut','state_name' => 'CT', 'sort_order' => '7'],
            ['state_prefix' => 'Delaware','state_name' => 'DE', 'sort_order' => '8'],
            // ['state_prefix' => 'District of Columbia','state_name' => 'DC', 'sort_order' => '9' ],
            ['state_prefix' => 'Florida','state_name' => 'FL', 'sort_order' => '10' ],
            ['state_prefix' => 'Georgia','state_name' => 'GA', 'sort_order' => '11' ],
            ['state_prefix' => 'Hawaii','state_name' => 'HI', 'sort_order' => '12'  ],
            ['state_prefix' => 'Idaho','state_name' => 'ID', 'sort_order' => '13'],
            ['state_prefix' => 'Illinois','state_name' => 'IL', 'sort_order' => '14'],
            ['state_prefix' => 'Indiana','state_name' => 'IN', 'sort_order' => '15'],
            ['state_prefix' => 'Iowa','state_name' => 'IA', 'sort_order' => '16'],
            ['state_prefix' => 'Kansas','state_name' => 'KS', 'sort_order' => '17'],
            ['state_prefix' => 'Kentucky','state_name' => 'KY', 'sort_order' => '18'],
            ['state_prefix' => 'Louisiana','state_name' => 'LA', 'sort_order' => '19'],
            ['state_prefix' => 'Maine','state_name' => 'ME', 'sort_order' => '20'],
            ['state_prefix' => 'Maryland','state_name' => 'MD', 'sort_order' => '21'
            ],
            ['state_prefix' => 'Massachusetts','state_name' => 'MA', 'sort_order' => '22'
            ],
            ['state_prefix' => 'Michigan','state_name' => 'MI', 'sort_order' => '23'
            ],
            ['state_prefix' => 'Minnesota','state_name' => 'MN', 'sort_order' => '24'
            ],
            ['state_prefix' => 'Mississippi','state_name' => 'MS', 'sort_order' => '25'
            ],
            ['state_prefix' => 'Missouri','state_name' => 'MO', 'sort_order' => '26'
            ],
            ['state_prefix' => 'Montana','state_name' => 'MT', 'sort_order' => '27'
            ],
            ['state_prefix' => 'Nebraska','state_name' => 'NE', 'sort_order' => '28'
            ],
            ['state_prefix' => 'Nevada','state_name' => 'NV', 'sort_order' => '29'
            ], 
            ['state_prefix' => 'New Hampshire','state_name' => 'NH', 'sort_order' => '30'
            ],
            ['state_prefix' => 'New Jersey','state_name' => 'NJ', 'sort_order' => '31'
            ],
            ['state_prefix' => 'New Mexico','state_name' => 'NM', 'sort_order' => '32'
            ],
            ['state_prefix' => 'New York','state_name' => 'NY', 'sort_order' => '33'
            ],
            ['state_prefix' => 'North Carolina','state_name' => 'NC', 'sort_order' => '34'
            ],
            ['state_prefix' => 'North Dakota','state_name' => 'ND', 'sort_order' => '35'
            ],
            ['state_prefix' => 'Ohio','state_name' => 'OH', 'sort_order' => '36'
            ],
            ['state_prefix' => 'Oklahoma','state_name' => 'OK', 'sort_order' => '37'
            ],
            ['state_prefix' => 'Oregon','state_name' => 'OR', 'sort_order' => '38'
            ],
            ['state_prefix' => 'Pennsylvania','state_name' => 'PA', 'sort_order' => '39'
            ],
            ['state_prefix' => 'Rhode Island','state_name' => 'RI', 'sort_order' => '40'
            ],
            ['state_prefix' => 'South Carolina','state_name' => 'SC', 'sort_order' => '41'
            ],
            ['state_prefix' => 'South Dakota','state_name' => 'SD', 'sort_order' => '42'
            ],
            ['state_prefix' => 'Tennessee','state_name' => 'TN', 'sort_order' => '43'
            ],
            ['state_prefix' => 'Texas','state_name' => 'TX', 'sort_order' => '44'
            ],
            ['state_prefix' => 'Utah','state_name' => 'UT', 'sort_order' => '45'
            ],
            ['state_prefix' => 'Vermont','state_name' => 'VT', 'sort_order' => '46'
            ],
            ['state_prefix' => 'Virginia','state_name' => 'VA', 'sort_order' => '47'
            ],
            ['state_prefix' => 'Washington','state_name' => 'WA', 'sort_order' => '48'
            ],
            ['state_prefix' => 'West Virginia','state_name' => 'WV', 'sort_order' => '49'
            ],
            ['state_prefix' => 'Wisconsin','state_name' => 'WI', 'sort_order' => '50'
            ],
            ['state_prefix' => 'Wyoming','state_name' => 'WY', 'sort_order' => '51'
            ],

            // ['state_prefix' => 'Puerto Rico','state_name' => 'PR', 'sort_order' => '52'
            // ],
            //  ['state_prefix' => 'U.S. Virgin Islands','state_name' => 'VI', 'sort_order' => '53'
            // ],
            //  ['state_prefix' => 'American Samoa','state_name' => 'AS', 'sort_order' => '54'
            // ],
            //  ['state_prefix' => 'Northern Mariana Islands','state_name' => 'MP', 'sort_order' => '55'
            // ],
            //  ['state_prefix' => 'Guam','state_name' => 'GU', 'sort_order' => '56'
            // ],
            //  ['state_prefix' => 'Non US','state_name' => 'Non US', 'sort_order' => '57'
            // ],

        ]);
    }
}
