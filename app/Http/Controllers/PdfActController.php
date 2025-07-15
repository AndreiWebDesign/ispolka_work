<?php


namespace App\Http\Controllers;
use App\Models\HiddenWork;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use setasign\Fpdi\Fpdi;
use mikehaertl\pdftk\Pdf;
use Illuminate\Support\Facades\Storage;


class PdfActController extends Controller
{

    public function getHash($id)
    {
        $act = HiddenWork::findOrFail($id);

        $pdfPath = storage_path("app/pdf_outputs/act_{$id}.pdf");

        if (!file_exists($pdfPath)) {
            // Автогенерация PDF перед вычислением хэша
            $templatePath = storage_path('app/pdf_templates/hidden_work_template.pdf');

            $fields = [
                'act_number' => $act->act_number,
                'city' => $act->city,
                'act_date' => $act->act_date,
                'object_name' => $act->object_name,
                'contractor_representative' => $act->contractor_representative,
                'tech_supervisor_representative' => $act->tech_supervisor_representative,
                'author_supervisor_representative' => $act->author_supervisor_representative,
                'additional_participants' => $act->additional_participants,
                'work_executor' => $act->work_executor,
                'hidden_works' => $act->hidden_works,
                'psd_info' => $act->psd_info,
                'materials' => $act->materials,
                'compliance_evidence' => $act->compliance_evidence,
                'deviations' => $act->deviations,
                'start_date' => $act->start_date,
                'end_date' => $act->end_date,
                'commission_decision' => $act->commission_decision,
                'next_works' => $act->next_works,
                'contractor_sign_name' => $act->contractor_sign_name,
                'contractor_sign' => $act->contractor_sign,
                'tech_supervisor_sign_name' => $act->tech_supervisor_sign_name,
                'tech_supervisor_sign' => $act->tech_supervisor_sign,
                'author_supervisor_sign_name' => $act->author_supervisor_sign_name,
                'author_supervisor_sign' => $act->author_supervisor_sign,
                'additional_signs' => $act->additional_signs,
            ];

            $pdf = new Pdf($templatePath);
            $pdf->fillForm($fields)
                ->saveAs($pdfPath);
        }

        if (!file_exists($pdfPath)) {
            return response()->json(['error' => 'PDF не найден'], 404);
        }

        $hash = base64_encode(hash_file('sha256', $pdfPath, true));

        return response()->json(['base64hash' => $hash]);
    }


    public function signPdf(Request $request)
    {
        $id = $request->input('id');
        $cmsBase64 = $request->input('cms');

        $inputPath = storage_path("app/pdf_outputs/act_{$id}.pdf");
        $outputPath = storage_path("app/pdf_signed/act_signed_{$id}.pdf");

        if (!file_exists($inputPath)) {
            return response()->json(['error' => 'PDF не найден'], 404);
        }

        // Распаковываем CMS во временный файл
        $cms = base64_decode($cmsBase64);
        $cmsPath = storage_path("app/temp_cms_{$id}.p7s");
        file_put_contents($cmsPath, $cms);

        // Извлекаем сертификат
        $certOutput = shell_exec("openssl pkcs7 -inform DER -in {$cmsPath} -print_certs -noout");
        unlink($cmsPath);

        // Извлекаем IIN из SERIALNUMBER
        preg_match('/SERIALNUMBER=(\d+)/', $certOutput, $match);
        $iin = $match[1] ?? '000000000000';

        // ФИО из CN
        preg_match('/CN=([^\/,\n]+)/', $certOutput, $match);
        $fullName = trim($match[1] ?? 'ФИО');

        // Примерное разбиение ФИО
        [$surname, $name, $middlename] = array_pad(explode(' ', $fullName), 3, '');

        // Генерация XML <Person>
        $personXml = <<<XML
<Person>
    <IIN>{$iin}</IIN>
    <SurName>{$surname}</SurName>
    <Name>{$name}</Name>
    <MiddleName>{$middlename}</MiddleName>
    <BirthDate>1980-01-01</BirthDate>
    <BirthPlace>
        <Country>Kazakhstan</Country>
        <CountryKz>Қазақстан</CountryKz>
        <District>Алматы</District>
        <DistrictKz>Алматы</DistrictKz>
        <City>Алматы</City>
        <CityKz>Алматы</CityKz>
        <Locality>Центр</Locality>
        <LocalityKz>Орталық</LocalityKz>
    </BirthPlace>
</Person>
XML;

        $xmlPath = storage_path("app/temp_person_{$id}.xml");
        file_put_contents($xmlPath, $personXml);

        // Архивация XML в ZIP
        $zipPath = storage_path("app/temp_person_{$id}.zip");
        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE);
        $zip->addFile($xmlPath, 'person.xml');
        $zip->close();
        unlink($xmlPath);

        $zipBase64 = base64_encode(file_get_contents($zipPath));
        unlink($zipPath);

        // Создание XML BarcodeElement
        $now = now()->format('Y-m-d\TH:i:s.vP');
        $barcodeXml = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<BarcodeElement xmlns="http://barcodes.pdf.shep.nitec.kz/">
    <creationDate>{$now}</creationDate>
    <elementData>{$zipBase64}</elementData>
    <elementNumber>1</elementNumber>
    <elementsAmount>1</elementsAmount>
    <FavorID>{$iin}</FavorID>
</BarcodeElement>
XML;

        Storage::put("qr_xml/act_{$id}.xml", $barcodeXml);

        // Генерация QR-кода с этим XML (можно также URL, если предпочтительно)
        $qr = QrCode::create($barcodeXml)->setSize(250);
        $writer = new PngWriter();
        $qrPng = $writer->write($qr)->getString();

        $qrPath = storage_path("app/temp_qr_{$id}.png");
        file_put_contents($qrPath, $qrPng);

        // Вставка в PDF
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($inputPath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $tplIdx = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplIdx);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplIdx);
            if ($i === $pageCount) {
                $pdf->Image($qrPath, $size['width'] - 60, $size['height'] - 60, 50, 50);
            }
        }

        unlink($qrPath);

        $pdf->Output($outputPath, 'F');
        return response()->download($outputPath, "Акт_подписанный_{$id}.pdf")->deleteFileAfterSend(true);
    }

}
