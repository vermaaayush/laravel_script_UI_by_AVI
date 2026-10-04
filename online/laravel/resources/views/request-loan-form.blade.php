<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-4xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('loan-summary') }}">Credit Facilities</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Application</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Loan Facility Application</h1>
        <p class="text-sm text-secondary mt-1">Complete the digital credit application form and attach necessary identity proof.</p>
    </div>

    @include('flash::message')

    <!-- Form -->
    <form id="loanForm" method="POST" action="{{ asset('insert-loan-request') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Step 1: Personal Information -->
        <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                <div class="w-9 h-9 rounded-xl bg-primary/10 border border-primary/20 text-primary flex items-center justify-center font-bold text-sm">
                    1
                </div>
                <div>
                    <h3 class="text-base font-heading font-bold text-on-surface">Personal & Identity Information</h3>
                    <p class="text-xs text-secondary">Official applicant details for credit assessment</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="fname" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">First Name <span class="text-error">*</span></label>
                    <input type="text" name="fname" id="fname" required placeholder="First name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label for="lname" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Last Name <span class="text-error">*</span></label>
                    <input type="text" name="lname" id="lname" required placeholder="Last name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label for="dob" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Date of Birth <span class="text-error">*</span></label>
                    <input type="date" name="dob" id="dob" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Email Address <span class="text-error">*</span></label>
                    <input type="email" name="email" id="email" required placeholder="name@domain.com" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label for="mobile" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Mobile Number <span class="text-error">*</span></label>
                    <input type="text" name="mobile" id="mobile" required placeholder="+1 (555) 000-0000" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label for="taken_loan_before" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Previous Credit History? <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="taken_loan_before" id="taken_loan_before" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="No">No (First Time Borrower)</option>
                            <option value="Yes">Yes (Existing Borrowing History)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div class="sm:col-span-3">
                    <label for="address" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Residential Address <span class="text-error">*</span></label>
                    <input type="text" name="address" id="address" required placeholder="Street address, Apartment / Suite" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-medium focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div class="sm:col-span-2">
                    <label for="city" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">City <span class="text-error">*</span></label>
                    <input type="text" name="city" id="city" required placeholder="City name" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-medium focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
                <div>
                    <label for="state" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">State / Province <span class="text-error">*</span></label>
                    <input type="text" name="state" id="state" required placeholder="State / Region" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-medium focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
            </div>
        </div>

        <!-- Step 2: Loan Facility Details -->
        <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                <div class="w-9 h-9 rounded-xl bg-primary/10 border border-primary/20 text-primary flex items-center justify-center font-bold text-sm">
                    2
                </div>
                <div>
                    <h3 class="text-base font-heading font-bold text-on-surface">Loan Facility Specifications</h3>
                    <p class="text-xs text-secondary">Structure your requested principal and repayment timeline</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="account_no" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Associated Account <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="account_no" id="account_no" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-mono font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Account --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_type }})</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>

                <div>
                    <label for="loan_type" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Type of Loan <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="loan_type" id="loan_type" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Loan Type --</option>
                            <option value="Home Loan">Home Loan (Mortgage Facility)</option>
                            <option value="Car Loan">Auto / Vehicle Loan</option>
                            <option value="Credit Loan">Personal / Unsecured Credit</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>

                <div>
                    <label for="loan_amount" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Requested Principal Amount <span class="text-error">*</span></label>
                    <input type="number" step="0.01" name="loan_amount" id="loan_amount" required placeholder="e.g. 50000" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-mono font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>

                <div>
                    <label for="loan_tenure" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Tenure (Months) <span class="text-error">*</span></label>
                    <input type="number" name="loan_tenure" id="loan_tenure" required placeholder="e.g. 24, 36, 60" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>

                <div class="sm:col-span-2">
                    <label for="employment_type" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Primary Income / Employment Type <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="employment_type" id="employment_type" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Employment Classification --</option>
                            <option value="Salaried">Salaried Corporate Professional</option>
                            <option value="Salaried Doctor">Salaried Medical Practitioner / Doctor</option>
                            <option value="Self Employed Business">Self-Employed Business Owner / Director</option>
                            <option value="Self Employed Professional">Independent Professional / Consultant</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Documents & Verification -->
        <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                <div class="w-9 h-9 rounded-xl bg-primary/10 border border-primary/20 text-primary flex items-center justify-center font-bold text-sm">
                    3
                </div>
                <div>
                    <h3 class="text-base font-heading font-bold text-on-surface">Verification Documents & Declarations</h3>
                    <p class="text-xs text-secondary">Provide official identity and income records</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="photo" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Applicant Photograph <span class="text-error">*</span></label>
                    <input type="file" name="photo" id="photo" required accept="image/*" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl p-2.5 text-xs text-secondary file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary file:text-on-primary hover:file:bg-primary-container cursor-pointer">
                </div>

                <div>
                    <label for="signature" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Digital Signature Image <span class="text-error">*</span></label>
                    <input type="file" name="signature" id="signature" required accept="image/*" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl p-2.5 text-xs text-secondary file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary file:text-on-primary hover:file:bg-primary-container cursor-pointer">
                </div>

                <div class="sm:col-span-2">
                    <label for="salary_slip" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Recent Paystub / Proof of Income (Optional)</label>
                    <input type="file" name="salary_slip" id="salary_slip" accept="image/*" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl p-2.5 text-xs text-secondary file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary file:text-on-primary hover:file:bg-primary-container cursor-pointer">
                </div>
            </div>

            <!-- Legal Consent Checkbox -->
            <label for="info_correct" class="flex items-start gap-3 p-4 rounded-2xl bg-surface-container-low border border-outline-variant/30 cursor-pointer hover:bg-surface-container transition-colors">
                <input type="checkbox" name="info_correct" id="info_correct" required value="1" class="w-4 h-4 text-primary focus:ring-primary accent-primary rounded mt-0.5">
                <span class="text-xs text-secondary leading-relaxed">
                    I solemnly declare that all personal and financial disclosures submitted above are true, accurate, and complete. I authorize the Bank and its verified credit reporting agencies to inspect my credit file and contact me regarding this financing request.
                </span>
            </label>

            <!-- Actions -->
            <div class="pt-4 border-t border-surface-container flex items-center justify-end gap-3">
                <a href="{{ url('request-loan') }}" class="px-5 py-3 rounded-full border border-outline-variant/30 bg-surface-container-lowest hover:bg-surface-container text-secondary text-xs font-bold uppercase tracking-wider transition-colors">
                    Back
                </a>
                <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider rounded-full shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span> Submit Loan Application
                </button>
            </div>
        </div>
    </form>
</div>

@include('footer')
