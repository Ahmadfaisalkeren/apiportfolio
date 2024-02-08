<?php

namespace App\Services;

use App\Http\Requests\CertificatesStoreRequest;
use App\Models\Certificates;
use Illuminate\Support\Facades\Storage;

/**
 * Class CertificatesService.
 */
class CertificatesService
{
    public function getCertificates()
    {
        $certificates = Certificates::all();

        return $certificates;
    }

    private function storeImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images/certificates', $imageName, 'public');

        return $imagePath;
    }

    public function storeCertificate(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->storeImage($data['image']);
        }
        Certificates::create($data);
    }

    public function getCertificateById($id)
    {
        $certificate = Certificates::findOrFail($id);

        return $certificate;
    }

    private function updateImage(Certificates $certificate, $image = null)
    {
        if ($image && $image->isValid()) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images/certificates', $imageName);

            if ($certificate->image) {
                Storage::delete('public/' . $certificate->image);
            }

            $certificate->image = str_replace('public/', '', $imagePath);
        }
    }

    public function updateCertificate(Certificates $certificate, array $data)
    {
        $certificate->year = $data['year'] ?? $certificate->year;
        $certificate->description = $data['description'] ?? $certificate->description;

        $this->updateImage($certificate, $data['image'] ?? null);

        $certificate->save();

        return $certificate;
    }

    private function deleteImage($imagePath)
    {
        if ($imagePath) {
            Storage::delete('public/' . $imagePath);
        }
    }

    public function deleteCertificate(Certificates $certificate)
    {
        $this->deleteImage($certificate->image);

        $certificate->delete();
    }
}
