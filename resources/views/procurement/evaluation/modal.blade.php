<div class="modal fade" id="modalEvaluationCompany" aria-hidden="true" aria-labelledby="modalEvaluationCompanyLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEvaluationCompanyLabel">Evaluation CMNP To Vendor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="evaluationCompanyForm" action="{{ route('evaluation.company', $procurement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vendor_name" class="col-form-label required">Vendor Name</label>
                        @foreach ($procurement->tenders as $tender)
                            @foreach ($tender->businessPartners as $businessPartner)
                                @if ($businessPartner->pivot->is_selected == '1')
                                <input type="hidden" class="form-control" name="type" id="type" value="3" readonly>
                                <input type="hidden" class="form-control" name="tender_id" id="tender_id" value="{{ $tender->id }}" readonly>
                                <input type="hidden" class="form-control" name="business_partner_id" id="business_partner_id" value="{{ $businessPartner->partner->id }}" readonly>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $businessPartner->partner->name }}" readonly>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="type_file" class="col-form-label required">Evaluation</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="evaluation" id="evaluation_0" value="0">
                                    <label class="form-check-label" for="evaluation_0">
                                        <h4>Buruk (Tidak Layak: &le; -60)</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="evaluation" id="evaluation_1" value="1">
                                    <label class="form-check-label" for="evaluation_1">
                                        <h4>Baik (Dipertahankan: 61-100)</h4>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('evaluation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_evaluation_company" class="col-form-label required">File Evaluation Company</label>
                        <input type="file" class="form-control" id="file_evaluation_company" name="file_evaluation_company" accept=".pdf">
                        @error('file_evaluation_company')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="notes" class="col-form-label required">Evaluation Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="evaluationCompanyBtn" name="evaluationCompanyBtn" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEvaluationVendor" aria-hidden="true" aria-labelledby="modalEvaluationVendorLabel" tabindex="-1">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEvaluationVendorLabel">Evaluation Vendor To CMNP</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="evaluationVendorForm" action="{{ route('evaluation.vendor', $procurement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="vendor_name" class="col-sm-2 col-form-label required">Vendor Name</label>
                        <div class="col-sm-10">
                            @foreach ($procurement->tenders as $tender)
                                @foreach ($tender->businessPartners as $businessPartner)
                                    @if ($businessPartner->pivot->is_selected == '1')
                                    <input type="hidden" class="form-control" name="type" id="type" value="4" readonly>
                                    <input type="hidden" class="form-control" name="tender_id" id="tender_id" value="{{ $tender->id }}" readonly>
                                    <input type="hidden" class="form-control" name="business_partner_id" id="business_partner_id" value="{{ $businessPartner->partner->id }}" readonly>
                                    <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $businessPartner->partner->name }}" readonly>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="value_cost" class="col-form-label required">Nilai Pekerjaan</label>
                                        <div class="row">
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="value_cost" id="value_cost_0" value="0">
                                                    <label class="form-check-label" for="value_cost_0">
                                                        <h4>0 s.d &lt; 100Jt</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="value_cost" id="value_cost_1" value="1">
                                                    <label class="form-check-label" for="value_cost_1">
                                                        <h4>&ge; 100Jt s.d &lt; 1 Miliar</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="value_cost" id="value_cost_2" value="2">
                                                    <label class="form-check-label" for="value_cost_2">
                                                        <h4>&ge; 1 Miliar</h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('value_cost')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="contract_order" class="col-form-label required">Penerbitan Kontrak &#47; PO</label>
                                        <div class="row">
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="contract_order" id="contract_order_0" value="0">
                                                    <label class="form-check-label" for="contract_order_0">
                                                        <h4>Cepat</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="contract_order" id="contract_order_1" value="1">
                                                    <label class="form-check-label" for="contract_order_1">
                                                        <h4>Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="contract_order" id="contract_order_2" value="2">
                                                    <label class="form-check-label" for="contract_order_2">
                                                        <h4>Sangat Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('contract_order')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="work_implementation" class="col-form-label required">Pelaksanaan Pekerjaan &#40; Koordinasi &#41;</label>
                                        <div class="row">
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="work_implementation" id="work_implementation_0" value="0">
                                                    <label class="form-check-label" for="work_implementation_0">
                                                        <h4>Mudah</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="work_implementation" id="work_implementation_1" value="1">
                                                    <label class="form-check-label" for="work_implementation_1">
                                                        <h4>Sulit</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="work_implementation" id="work_implementation_2" value="2">
                                                    <label class="form-check-label" for="work_implementation_2">
                                                        <h4>Sangat Sulit</h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('work_implementation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="pre_handover" class="col-form-label required">Pengajuan &#38; Pelaksanaan PHO</label>
                                        <div class="row">
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_0" value="0">
                                                    <label class="form-check-label" for="pre_handover_0">
                                                        <h4>Cepat</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_1" value="1">
                                                    <label class="form-check-label" for="pre_handover_1">
                                                        <h4>Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_2" value="2">
                                                    <label class="form-check-label" for="pre_handover_2">
                                                        <h4>Sangat Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pre_handover" id="pre_handover_3" value="3">
                                                    <label class="form-check-label" for="pre_handover_3">
                                                        <h4>Tidak Ada PHO</h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('pre_handover')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="final_handover" class="col-form-label required">Pengajuan &#38; Pelaksanaan FHO</label>
                                        <div class="row">
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_0" value="0">
                                                    <label class="form-check-label" for="final_handover_0">
                                                        <h4>Cepat</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_1" value="1">
                                                    <label class="form-check-label" for="final_handover_1">
                                                        <h4>Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_2" value="2">
                                                    <label class="form-check-label" for="final_handover_2">
                                                        <h4>Sangat Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="final_handover" id="final_handover_3" value="3">
                                                    <label class="form-check-label" for="final_handover_3">
                                                        <h4>Tidak Ada FHO</h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('final_handover')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="invoice_payment" class="col-form-label required">Pengajuan Invoice &#38; Real Pembayaran</label>
                                        <div class="row">
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="invoice_payment" id="invoice_payment_0" value="0">
                                                    <label class="form-check-label" for="invoice_payment_0">
                                                        <h4>Cepat</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="invoice_payment" id="invoice_payment_1" value="1">
                                                    <label class="form-check-label" for="invoice_payment_1">
                                                        <h4>Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="invoice_payment" id="invoice_payment_2" value="2">
                                                    <label class="form-check-label" for="invoice_payment_2">
                                                        <h4>Sangat Lama</h4>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('invoice_payment')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_evaluation_vendor" class="col-form-label required">File Evaluation Vendor</label>
                        <input type="file" class="form-control" id="file_evaluation_vendor" name="file_evaluation_vendor" accept=".pdf">
                        @error('file_evaluation_vendor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="notes" class="col-form-label required">Evaluation Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="1"></textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="evaluationVendorBtn" name="evaluationVendorBtn" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
