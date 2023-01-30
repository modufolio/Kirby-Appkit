<?php

use App\Core\SqlPage;

class AlbumPage extends SqlPage
{
    protected ?string $table = 'albums';

    protected string $identifier = 'slug';

    public function cover()
    {
        return $this->content()->get('cover')->toFile() ?? $this->image();
    }
}
