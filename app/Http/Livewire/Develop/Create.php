<?php

namespace App\Http\Livewire\Develop;

use App\Enums\AssetType;
use App\Models\Asset;
use App\Helpers\Cdn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use claviska\SimpleImage;

class Create extends Component
{
    use WithFileUploads;

    /**
     * @var AssetType
     */
    public $selected_type;

    /**
     * @var TemporaryUploadedFile
     */
    public $asset_file;

    /**
     * @var string
     */
    public $asset_name;

    public function __construct()
    {
        abort_unless(Auth::check(), 401);
    }

    public function mount()
    {
        abort_unless($this->selected_type->isDevelopCreatable(), 404);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'asset_name' => ['required', 'min:3', 'max:50'],
            'asset_file' => ['required', ... $this->selected_type->rules()]
        ];
    }

    public function upload()
    {
        $this->validate();

        if (RateLimiter::tooManyAttempts('create-asset:' . Auth::user()->id, 1))
        {
            $wait = RateLimiter::availableIn('create-asset:' . Auth::user()->id);
            $this->dispatchBrowserEvent('error', __('Please wait :time before creating a new :asset_type.', ['time' => seconds2human($wait), 'asset_type' => $this->selected_type->fullname()]));
            return;
        }

        // static thumbnail processing
        if (in_array($this->selected_type, [AssetType::TShirt, AssetType::Decal]))
        {
            try
            {
                $image = new SimpleImage($this->asset_file->getRealPath());
            }
            catch(\Exception $exception)
            {
                $this->addError('asset_file', __('Failed to process image, it might be corrupted?'));
                return;
            }

            if ($this->selected_type == AssetType::TShirt)
            {
                $imageData = new SimpleImage();
                $imageData->fromNew($image->getWidth(), $image->getWidth());
                
                $assetThumbnail = new SimpleImage(resource_path('img/tshirt-template.png'));
                $assetThumbnail->resize(420, 420);
                
                // fit the image in a 1:1 canvas, 420x420 max
                $imageData->resize($image->getWidth());
                $imageData->overlay($image, 'top');
                if ($image->getWidth() > 420) $imageData->resize(420, 420);

                // image thumbnail must be 420x420
                $imageThumbnail = clone $imageData;
                $imageThumbnail->resize(420, 420);

                // asset thumbnail is image thumbnail overlayed onto t-shirt template
                $assetThumbnailOverlay = clone $imageThumbnail;
                $assetThumbnailOverlay->resize(250, 250);
                $assetThumbnail->overlay($assetThumbnailOverlay, 'center', 1);
            }
            else if ($this->selected_type == AssetType::Decal)
            {
                // image retains original ratio, original size is retained if under 420x420
                $imageData = clone $image;
                $imageData->bestFit(420, 420);

                // image and asset thumbnails are the image resized to 420x420
                $imageThumbnail = clone $image;
                $imageThumbnail->resize(420, 420);
                $assetThumbnail = clone $imageThumbnail;
            }
            
            $imageData = $imageData->toString();
            $imageThumbnail = $imageThumbnail->toString();
            $assetThumbnail = $assetThumbnail->toString();

            RateLimiter::hit('create-asset:' . Auth::user()->id, 30);

            $imageAsset = Asset::create([
                'name' => $this->asset_name,
                'description' => $this->selected_type->fullname() . ' ' . AssetType::Image->name,
                'type' => AssetType::Image->value,
                'creator_id' => Auth::user()->id
            ]);
            
            $imageAsset->initialize($imageData, $imageThumbnail);
    
            $document = simplexml_load_file(resource_path(sprintf('xml/%s.xml', $this->selected_type->name)));
            $document->xpath("//url")[0][0] = sprintf('%s/asset/?id=%d', config('app.url'), $imageAsset->id);
            // we need to remove the first line that contains the XML declaration
            $assetData = $document->asXML();
            $assetData = preg_replace('/^.+\n/', '', $assetData); 
        }
        else
        {
            if ($this->selected_type == AssetType::Audio)
            {
                $assetThumbnail = file_get_contents(resource_path('img/audio.png'));
                $assetData = $this->asset_file->get();
            }

            if ($this->selected_type == AssetType::Animation)
            {
                $assetThumbnail = file_get_contents(resource_path('img/animation.png'));
                $assetData = $this->asset_file->get();
            }

            RateLimiter::hit('create-asset:' . Auth::user()->id, 30);
        }

        $asset = Asset::create([
            'name' => $this->asset_name,
            'description' => $this->selected_type->fullname(),
            'type' => $this->selected_type->value,
            'image_id' => $imageAsset->id ?? null,
            'creator_id' => Auth::user()->id
        ]);
    
        $asset->initialize($assetData, $assetThumbnail);

        if (in_array($this->selected_type, [AssetType::TShirt, AssetType::Decal]))
        {
            Cdn::save($imageData);
            Cdn::save($imageThumbnail, 'png');
        }
        
        Cdn::save($assetData);
        Cdn::save($assetThumbnail, 'png');

        $this->dispatchBrowserEvent('success', __('Successfully created :asset_type.', ["asset_type" => __($this->selected_type->fullname())]));

        $this->emitTo('develop.assets', 'assetCreated');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.develop.create')->with('selected_type', $this->selected_type);
    }
}
