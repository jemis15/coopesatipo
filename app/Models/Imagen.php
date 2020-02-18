<?php
namespace App\Models;

use App\Traits\HasDefaultImage;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model {
    use HasDefaultImage;

    protected $table = 'imagenes';

    public function getDurationAsString() {
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;
      
        return "Job duration: $years years $extraMonths months";
    }
}