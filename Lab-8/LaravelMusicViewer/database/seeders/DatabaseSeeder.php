<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(
            "
        insert into albums (date, title)
values ('1973-03-01', 'The Dark Side of the Moon');
set @albumId = last_insert_id();

insert into songs (album_id, title, duration)
values (@albumId, 'Speak To Me', '00:01:05');
insert into songs (album_id, title, duration)
values (@albumId, 'Breathe', '00:02:43');
insert into songs (album_id, title, duration)
values (@albumId, 'On the Run', '00:03:36');
insert into songs (album_id, title, duration)
values (@albumId, 'Time', '00:06:53');
insert into songs (album_id, title, duration)
values (@albumId, 'The Great Gig in the Sky', '00:04:36');
insert into songs (album_id, title, duration)
values (@albumId, 'Money', '00:06:23');
insert into songs (album_id, title, duration)
values (@albumId, 'Us and Them', '00:07:49');
insert into songs (album_id, title, duration)
values (@albumId, 'Any Colour You Like', '00:03:26');
insert into songs (album_id, title, duration)
values (@albumId, 'Brain Damage', '00:03:49');
insert into songs (album_id, title, duration)
values (@albumId, 'Eclipse', '00:02:03');

insert into albums (date, title)
values ('1967-05-26', 'Sgt. Pepper''s Lonely Hearts Club Band');
set @albumId = last_insert_id();

insert into songs (album_id, title, duration)
values (@albumId, 'Sgt. Pepper''s Lonely Hearts Club Band', '00:02:00');
insert into songs (album_id, title, duration)
values (@albumId, 'With a Little Help from My Friends', '00:02:42');
insert into songs (album_id, title, duration)
values (@albumId, 'Lucy in the Sky with Diamonds', '00:03:28');
insert into songs (album_id, title, duration)
values (@albumId, 'Getting Better', '00:02:48');
insert into songs (album_id, title, duration)
values (@albumId, 'Fixing a Hole', '00:02:36');
insert into songs (album_id, title, duration)
values (@albumId, 'She''s Leaving Home', '00:03:35');
insert into songs (album_id, title, duration)
values (@albumId, 'Being for the Benefit of Mr. Kite!', '00:02:37');
insert into songs (album_id, title, duration)
values (@albumId, 'Within You Without You', '00:05:05');
insert into songs (album_id, title, duration)
values (@albumId, 'When I''m Sixty-Four', '00:02:37');
insert into songs (album_id, title, duration)
values (@albumId, 'Lovely Rita', '00:02:42');
insert into songs (album_id, title, duration)
values (@albumId, 'Good Morning Good Morning', '00:02:42');
insert into songs (album_id, title, duration)
values (@albumId, 'Sgt. Pepper''s Lonely Hearts Club Band (Reprise)', '00:01:18');
insert into songs (album_id, title, duration)
values (@albumId, 'A Day in the Life', '00:05:38');

insert into albums (date, title)
values ('1971-10-08', 'Led Zeppelin IV');
set @albumId = last_insert_id();

insert into songs (album_id, title, duration)
values (@albumId, 'Black Dog', '00:04:54');
insert into songs (album_id, title, duration)
values (@albumId, 'Rock and Roll', '00:03:40');
insert into songs (album_id, title, duration)
values (@albumId, 'The Battle of Evermore', '00:05:51');
insert into songs (album_id, title, duration)
values (@albumId, 'Stairway to Heaven', '00:08:02');
insert into songs (album_id, title, duration)
values (@albumId, 'Misty Mountain Hop', '00:04:38');
insert into songs (album_id, title, duration)
values (@albumId, 'Four Sticks', '00:04:44');
insert into songs (album_id, title, duration)
values (@albumId, 'Going to California', '00:03:31');
insert into songs (album_id, title, duration)
values (@albumId, 'When the Levee Breaks', '00:07:07');
        "
        );
    }
}
