<?php

namespace App\Http\Controllers\API;

use App\Models\Certificates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CertificatesService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Certificates\CertificatesStoreRequest;
use App\Http\Requests\Certificates\CertificateUpdateRequest;

class CertificatesController extends Controller
{
    protected $certificateService;

    public function __construct(CertificatesService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function index()
    {
        $certificates = $this->certificateService->getCertificates();

        return response()->json([
            'message' => 'Certificates Fetched Successfully',
            'certificates' => $certificates,
        ]);
    }

    public function store(CertificatesStoreRequest $request)
    {
        $this->certificateService->storeCertificate($request->validated());

        return response()->json(
            [
                'status' => 200,
                'message' => 'Certificate Created Successfully',
            ],
            200,
        );
    }

    public function edit($id)
    {
        $certificate = Certificates::findOrFail($id);

        return response()->json(
            [
                'certificate' => $certificate,
                'status' => 200,
                'message' => 'Certificate Fetched Successfully',
            ],
            200,
        );
    }

    public function update(CertificateUpdateRequest $request, $id)
    {
        $certificate = Certificates::findOrFail($id);

        $this->certificateService->updateCertificate($certificate, $request->validated());

        return response()->json(
            [
                'message' => 'Certificate Updated Successfully',
                'status' => 200,
                'Certificate' => $certificate,
            ],
            200,
        );
    }

    public function destroy($id)
    {
        $certificate = Certificates::findOrFail($id);
        $this->certificateService->deleteCertificate($certificate);

        return response()->json(
            [
                'status' => 200,
                'message' => 'Certificate Deleted Successfully',
            ],
            200,
        );
    }
}
