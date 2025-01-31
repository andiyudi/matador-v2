@extends('layouts.template')
@section('content')
@php
$pretitle = 'Procurement';
$title    = 'Estimate';
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <label for="receipt" class="col-sm-2 col-form-label">TTPR</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="receipt" id="receipt" value="{{ $procurement->receipt }}" readonly>
                    </div>
                    <label for="number" class="col-sm-2 col-form-label">Procurement Number</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="number" name="number" value="{{ $procurement->number }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Job Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $procurement->name }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="division" class="col-sm-2 col-form-label">Division</label>
                    <div class="col-sm-4">
                        <input type="text" name="division" id="division" class="form-control" value="{{ $procurement->division->name }}" readonly">
                    </div>
                    <label for="person_in_charge" class="col-sm-2 col-form-label">PIC Pengadaan</label>
                    <div class="col-sm-4">
                        <input type="text" name="official" id="official" class="form-control" value="{{ $procurement->official->name }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="user_estimate" class="col-sm-2 col-form-label">User Estimate</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="text" class="form-control currency" id="user_estimate" name="user_estimate" value="{{ $procurement->user_estimate }}" readonly>
                        </div>
                    </div>
                    <label for="technique_estimate" class="col-sm-2 col-form-label">Technique Estimate</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="text" class="form-control currency" id="technique_estimate" name="technique_estimate" value="{{ $procurement->technique_estimate }}" readonly>
                        </div>
                    </div>
                </div>
                @php
                    $tenderIdsKeys = array_keys($tenderData);
                @endphp
                @for ($i = 0; $i < $tendersCount; $i++)
                    @php
                        $tenderId = $tenderIdsKeys[$i];
                        $idTender = old('id_' . $tenderId, isset($tenderData[$tenderId]['id']) ? $tenderData[$tenderId]['id'] : '');
                        $reportNegoResultValue = old('report_nego_result_' . $tenderId, isset($tenderData[$tenderId]['report_nego_result']) ? $tenderData[$tenderId]['report_nego_result'] : '');
                        $negoResultValue = old('negotiation_result_' . $tenderId, isset($tenderData[$tenderId]['negotiation_result']) ? $tenderData[$tenderId]['negotiation_result'] : '');
                    @endphp
                    <div class="row mb-3">
                        <label for="negotiation_result_{{ $tenderId }}" class="col-sm-2 col-form-label">
                            Hasil Nego (ke-{{ $i + 1 }})
                        </label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                                <input type="text" class="form-control currency negotiation-result" id="negotiation_result_{{ $idTender }}" name="negotiation_result_{{ $idTender }}" value="{{ $negoResultValue }}" readonly>
                            </div>
                        </div>
                        <label for="report_nego_result_{{ $tenderId }}" class="col-sm-2 col-form-label">
                            Laporan Hasil Nego (ke-{{ $i + 1 }}) ke Direksi
                        </label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="report_nego_result_{{ $idTender }}" name="report_nego_result_{{ $idTender }}" value="{{ $reportNegoResultValue }}" readonly>
                            <input type="hidden" name="tender_ids[]" value="{{ $idTender }}">
                        </div>
                    </div>
                @endfor
                @if($tendersCount > 0)
                <div class="row mb-3">
                    <label for="deal_nego" class="col-sm-2 col-form-label">Hasil Negosiasi Final</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="text" class="form-control currency" id="deal_nego" name="deal_nego" value="{{ $procurement->deal_nego ?? 0 }}" readonly>
                        </div>
                    </div>
                </div>
                @endif
                @if($procurementStatus == '1')
                <div class="row mb-3">
                    <label for="director_approval" class="col-sm-2 col-form-label">
                        Tanggal Persetujuan Direksi
                    </label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="director_approval" name="director_approval" value="{{ old('director_approval', $procurement->director_approval) }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="op_number" class="col-sm-2 col-form-label">
                        Nomor OP
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="op_number" name="op_number" value="{{ old('op_number', $procurement->op_number) }}" readonly>
                    </div>
                    <label for="contract_number" class="col-sm-2 col-form-label">
                        Nomor Kontrak
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="contract_number" name="contract_number" value="{{ old('contract_number', $procurement->contract_number) }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="contract_value" class="col-sm-2 col-form-label">
                        Nilai Kontrak
                    </label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="text" class="form-control currency" id="contract_value" name="contract_value" value="{{ old('contract_value', $procurement->contract_value) }}"  readonly>
                        </div>
                    </div>
                    <label for="contract_date" class="col-sm-2 col-form-label">
                        Tanggal Kontrak
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="contract_date" name="contract_date" value="{{ old('contract_date', $procurement->contract_date) }}" readonly>
                    </div>
                </div>
                @endif
                @if($procurementStatus == '2')
                <div class="row mb-3">
                    <label for="return_to_user" class="col-sm-2 col-form-label">
                        Tanggal Pengembalian ke User
                    </label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="return_to_user" name="return_to_user" value="{{ old('return_to_user', $procurement->return_to_user) }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="cancellation_memo" class="col-sm-2 col-form-label">Tanggal Memo Pembatalan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="cancellation_memo" id="cancellation_memo" cols="30" rows="3" readonly>{{ $procurement->cancellation_memo }}</textarea>
                    </div>
                </div>
                @endif
                @if ($procurementStatus == '1' || $procurementStatus == '2')
                <div class="row mb-3">
                    <label for="tender_day" class="col-sm-2 col-form-label">Waktu Penyelesaian Tender</label>
                    <label for="target_day" class="col-sm-1 col-form-label">Target &#40;A&#41;</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" name="target_day" id="target_day" value="{{ $procurement->target_day ?? 30 }}" min="1" readonly>
                    </div>
                    <label for="finish_day" class="col-sm-2 col-form-label">Selesai &#40;B&#41;</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="finish_day" name="finish_day" value="{{ $procurement->finish_day ?? 0 }}" min="1" readonly>
                    </div>
                    <label for="off_day" class="col-sm-1 col-form-label">Libur &#40;C&#41;</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" name="off_day" id="off_day" value="{{ $procurement->off_day ?? 0 }}" readonly>
                    </div>
                    <label for="difference_day" class="col-sm-2 col-form-label">Selisih &#40;A&#45;B&#43;C&#41;</label>
                    <div class="col-sm-1">
                        <input type="number" class="form-control" id="difference_day" name="difference_day" value="{{ $procurement->difference_day ?? 0 }}" readonly>
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <label for="information" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="information" id="information" cols="30" rows="3" readonly>{{ $procurement->information }}</textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="ppoe_accepted" class="col-sm-2 col-form-label">
                        PR &#43; OE Diterima
                    </label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="ppoe_accepted" name="ppoe_accepted" value="{{ old('ppoe_accepted', $procurement->ppoe_accepted) }}"  readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="division_disposition" class="col-sm-2 col-form-label">
                        Disposisi Manajer Umum Ke Kadep Pengadaan
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="division_disposition" name="division_disposition" value="{{ old('division_disposition', $procurement->division_disposition) }}" readonly>
                    </div>
                    <label for="departement_disposition" class="col-sm-2 col-form-label">
                        Disposisi Kadep Pengadaan Ke Seksi
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="departement_disposition" name="departement_disposition" value="{{ old('departement_disposition', $procurement->departement_disposition) }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="vendor_offer" class="col-sm-2 col-form-label">
                        Penawaran Kerjasama Ke Vendor
                    </label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="vendor_offer" name="vendor_offer" value="{{ old('vendor_offer', $procurement->vendor_offer) }}" readonly>
                    </div>
                </div>
                @php
                    $tenderIdsKeys = array_keys($tenderData);
                @endphp
                @for ($i = 0; $i < $tendersCount; $i++)
                    @php
                        $tenderId = $tenderIdsKeys[$i];
                        $idTender = old('id_' . $tenderId, isset($tenderData[$tenderId]['id']) ? $tenderData[$tenderId]['id'] : '');
                        $aanwijzingValue = old('aanwijzing_' . $tenderId, isset($tenderData[$tenderId]['aanwijzing']) ? $tenderData[$tenderId]['aanwijzing'] : '');
                        $openTenderValue = old('open_tender_' . $tenderId, isset($tenderData[$tenderId]['open_tender']) ? $tenderData[$tenderId]['open_tender'] : '');
                        $reviewTechniqueInValue = old('review_technique_in_' . $tenderId, isset($tenderData[$tenderId]['review_technique_in']) ? $tenderData[$tenderId]['review_technique_in'] : '');
                        $reviewTechniqueOutValue = old('review_technique_out_' . $tenderId, isset($tenderData[$tenderId]['review_technique_out']) ? $tenderData[$tenderId]['review_technique_out'] : '');
                    @endphp
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <input type="hidden" name="tender_ids[]" value="{{ $idTender }}">
                            <label for="aanwijzing_{{ $tenderId }}" class="col-form-label">
                                Aanwijzing (ke-{{ $i + 1 }})
                            </label>
                            <input type="date" class="form-control" id="aanwijzing_{{ $idTender }}" name="aanwijzing_{{ $idTender }}" value="{{ $aanwijzingValue }}" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label for="open_tender_{{ $tenderId }}" class="col-form-label">
                                Tender (Pembukaan Harga) (ke-{{ $i + 1 }})
                            </label>
                            <input type="date" class="form-control" id="open_tender_{{ $idTender }}" name="open_tender_{{ $idTender }}" value="{{ $openTenderValue }}" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label for="review_technique_out_{{ $tenderId }}" class="col-form-label">
                                Review Teknik Keluar (ke-{{ $i + 1 }})
                            </label>
                            <input type="date" class="form-control" id="review_technique_out_{{ $idTender }}" name="review_technique_out_{{ $idTender }}" value="{{ $reviewTechniqueOutValue }}" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label for="review_technique_in_{{ $tenderId }}" class="col-form-label">
                                Review Teknik Masuk (ke-{{ $i + 1 }})
                            </label>
                            <input type="date" class="form-control" id="review_technique_in_{{ $idTender }}" name="review_technique_in_{{ $idTender }}" value="{{ $reviewTechniqueInValue }}" readonly>
                        </div>
                    </div>
                @endfor
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="disposition_second_tender" class="col-form-label">
                            Disposisi Untuk Nego Ulang
                        </label>
                        <input type="date" class="form-control" id="disposition_second_tender" name="disposition_second_tender" value="{{ $procurement->disposition_second_tender }}" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="renegotiation_result" class="col-form-label">
                            Hasil Nego Ulang
                        </label>
                        <input type="date" class="form-control" id="renegotiation_result" name="renegotiation_result" value="{{ $procurement->renegotiation_result }}" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="tender_result" class="col-form-label">
                            Laporan Hasil Tender
                        </label>
                        <input type="date" class="form-control" id="tender_result" name="tender_result" value="{{ $procurement->tender_result }}" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="director_agreement" class="col-form-label">
                            Persetujuan
                        </label>
                        <input type="date" class="form-control" id="director_agreement" name="director_agreement" value="{{ $procurement->director_agreement }}" readonly>
                    </div>
                </div>
                @if($procurementStatus == '1')
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="legal_accept" class="col-form-label">
                            Terima Dari Biro Hukum
                        </label>
                        <input type="date" class="form-control" id="legal_accept" name="legal_accept" value="{{ $procurement->legal_accept }}" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="general_accept" class="col-form-label">
                            Paraf Mandiv Umum
                        </label>
                        <input type="date" class="form-control" id="general_accept" name="general_accept" value="{{ $procurement->general_accept }}" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="user_accept" class="col-form-label">
                            Paraf User
                        </label>
                        <input type="date" class="form-control" id="user_accept" name="user_accept" value="{{ $procurement->user_accept }}" readonly>
                    </div>
                    <div class="col-sm-3">
                        <label for="vendor_accept" class="col-form-label">
                            Ttd Vendor
                        </label>
                        <input type="date" class="form-control" id="vendor_accept" name="vendor_accept" value="{{ $procurement->vendor_accept }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="director_accept" class="col-sm-2 col-form-label">
                        Diserahkan Ke Biro Hukum Untuk Ttd Direksi
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="director_accept" name="director_accept" value="{{ $procurement->director_accept }}" readonly>
                    </div>
                    <label for="contract_from_legal" class="col-sm-2 col-form-label">
                        Final Kontrak Dari Biro Hukum
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="contract_from_legal" name="contract_from_legal" value="{{ $procurement->contract_from_legal }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="contract_to_vendor" class="col-sm-2 col-form-label">
                        Final Kontrak / OP Diserahkan Ke Vendor
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="contract_to_vendor" name="contract_to_vendor" value="{{ $procurement->contract_to_vendor }}" readonly>
                    </div>
                    <label for="contract_to_user" class="col-sm-2 col-form-label">
                        Final Kontrak Diserahkan Ke User
                    </label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="contract_to_user" name="contract_to_user" value="{{ $procurement->contract_to_user }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="input_sap" class="col-sm-2 col-form-label">
                        Input SAP (PO)
                    </label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="input_sap" name="input_sap" value="{{ old('input_sap', $procurement->input_sap) }}" readonly>
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <label for="document_tender_table" class="col-sm-2 col-form-label">Tender Document</label>
                    <div class="col-sm-10">
                        <table class="table table-responsive table-bordered table-striped table-hover" id="document_tender_table">
                            <thead>
                                <tr>
                                    <th>Nama File</th>
                                    <th>Type File</th>
                                    <th>Catatan File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="document_tender_list">
                                @foreach ($procurement->tenders as $tender)
                                    @foreach ($tender->tenderFile as $tenderFile)
                                    <tr>
                                        <td>{{ $tenderFile->name }}</td>
                                        <td>
                                            @if ($tenderFile->type === 0)
                                            File Selected Vendor
                                            @elseif ($tenderFile->type === 1)
                                            File Cancelled Tender
                                            @elseif ($tenderFile->type === 2)
                                            File Repeat Tender
                                            @elseif ($tenderFile->type === 3)
                                            File Selected Vendor From Past Tender
                                            @elseif ($tenderFile->type === 4)
                                            File Evaluation CMNP to Vendor
                                            @elseif ($tenderFile->type === 5)
                                            File Evaluation Vendor to CMNP
                                            @elseif ($tenderFile->type === 6)
                                            File Rollback Tender
                                            @else
                                            Unknown
                                            @endif
                                        </td>
                                        <td>{{ $tenderFile->notes }}</td>
                                        <td>
                                            <a href="{{ asset('storage/'.$tenderFile->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="procurement-file-table" class="col-sm-2 col-form-label">Procurement Document</label>
                    <div class="col-sm-10">
                        <table class="table table-responsive table-bordered table-striped table-hover" id="procurement-file-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Type File</th>
                                    <th>Catatan File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="procurement-file-table">
                                @foreach ($files as $index => $file)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $file->name }}</td>
                            <td>
                                @if (isset($definitions[$file->id]))
                                    {{ $definitions[$file->id]->name }}
                                @else
                                    Unknown Type
                                @endif
                            </td>
                            <td>{{ $file->notes }}</td>
                            <td>
                                <div class="d-grid gap-2 d-md-flex">
                                    <a href="{{ asset('storage/'.$file->path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a type="button" href="{{ route('administration.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#procurement-file-table').DataTable({
            aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            iDisplayLength: 5,
            dom: '<"top"rt><"bottom"flp><"clear">',
        });
    });
</script>
@include('procurement.administration.script')
@endsection
@push('after-style')
<style>
    .dataTables_wrapper .bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endpush
