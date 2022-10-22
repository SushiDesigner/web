<?php

namespace App\Http\Livewire\Admin;

use App\Models\Action;
use App\Enums\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class Alert extends Component
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $expiry;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'max:512'],
            'color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'expiry' => ['date', 'after:today'],
        ];
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function __construct()
    {
        abort_unless(Auth::check(), 401);

        /** @var \App\Models\User */
        $user = Auth::user();
        abort_unless($user->isSuperAdmin(), 401);
    }

    public function mount()
    {
        $this->text = Cache::get('alert')?->text ?? '';
        $this->color = Cache::get('alert')?->color ?? '';
        $this->expiry = Cache::get('expiry')?->expiry->format('m/d/Y') ?? '';
    }

    public function submit()
    {
        $data = $this->validate();

        if (!empty($data['expiry']))
        {
            Cache::remember('alert', (Carbon::parse($data['expiry'])->timestamp - Carbon::now()->timestamp), function() use ($data) {
                return (object) [
                    'text' => $data['text'],
                    'color' => $data['color'],
                    'expiry' => Carbon::parse($data['expiry']),
                ];
            });
        }
        else
        {
            Cache::put('alert', (object) [
                'text' => $data['text'],
                'color' => $data['color'],
            ]);
        }

        Action::log(Request::user(), Actions::SiteAlert);

        return $this->dispatchBrowserEvent('reload');
    }

    public function render()
    {
        return view('livewire.admin.alert');
    }
}
