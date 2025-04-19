<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Casts\TelefoneCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class TelefoneCastTest extends TestCase
{
    public function testTelefoneCast()
    {
        $model = new class extends Model {
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $model->telefone = '1133334444';
        $this->assertEquals('1133334444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 3333-4444', $model->telefone);
        // telefone móvel
        $model->telefone = '11999994444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testTelefoneFormated()
    {
        $model = new class extends Model {
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $model->telefone = '(11) 3333-4444';
        $this->assertEquals('1133334444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 3333-4444', $model->telefone);
        // telefone móvel
        $model->telefone = '(11) 99999-4444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testFillable()
    {
        $model = new class (['telefone' => '1133334444']) extends Model {
            protected $fillable = ['telefone'];
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $this->assertEquals('1133334444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 3333-4444', $model->telefone);
        // telefone móvel
        $model = new class (['telefone' => '11999994444']) extends Model {
            protected $fillable = ['telefone'];
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testTelefoneCastAsDefault()
    {
        $model = new class extends Model {
            protected function casts(): array
            {
                return ['telefone' => TelefoneCast::class];
            }
        };
        $model->telefone = '(11) 99999-4444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
        // tests fillable
        $model = new class (['telefone' => '11999994444']) extends Model {
            protected $fillable = ['telefone'];

            protected function casts()
            {
                return ['telefone' => TelefoneCast::class];
            }
        };
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testTelefoneCastAsString()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['telefone' => TelefoneCast::dbType(DBType::STRING)];
            }
        };
        $model->telefone = '(11) 99999-4444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
        // passing not formatted value
        $model->telefone = '11999994444';
        $this->assertEquals('11999994444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testTelefoneCastAsInteger()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['telefone' => TelefoneCast::dbType(DBType::INTEGER)];
            }
        };
        $model->telefone = '(11) 99999-4444';
        $this->assertEquals(11999994444, $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
        // passing integer value
        $model->telefone = 11999994444;
        $this->assertEquals(11999994444, $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testTelefoneCastAsFormatted()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['telefone' => TelefoneCast::dbType(DBType::FORMATTED)];
            }
        };
        $model->telefone = '11999994444';
        $this->assertEquals('(11) 99999-4444', $model->getAttributes()['telefone']);
        $this->assertEquals('(11) 99999-4444', $model->telefone);
    }

    public function testNull()
    {
        $model = new class extends Model {
            protected $casts = ['telefone' => TelefoneCast::class];
        };
        $model->telefone = null;
        $this->assertEquals(null, $model->getAttributes()['telefone']);
        $this->assertEquals(null, $model->telefone);
    }
}
