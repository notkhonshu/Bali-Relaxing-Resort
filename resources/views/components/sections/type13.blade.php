@php
    $id        = $section_data['id'] ?? 'contact_form';
    $tag_title = in_array($section_data['tag_title'] ?? 'h3', ['h2', 'h3', 'h4', 'p', 'div'], true)
        ? $section_data['tag_title']
        : 'h3';
    $title     = trim((string) ($section_data['title'] ?? 'Send a Message'));
    $action    = $section_data['action'] ?? '';

    $field = 'w-full border border-theme bg-background px-4 py-3 text-fluid-body focus:outline-none focus:border-primary transition-colors duration-200';
    $label = 'block mb-2 text-fluid-body text-muted';
    $error = 'mt-1.5 text-sm text-primary';
@endphp

@if (filled($action))
    <div id="{{ $id }}" class="section-type-13 scroll-mt-28">
        <{!! $tag_title !!} class="font-heading text-fluid-h3 mb-5">{{ $title }}</{!! $tag_title !!}>

        @if (session('contact_status'))
            <p role="status" class="mb-6 border border-theme px-4 py-3 text-fluid-body text-body">{{ session('contact_status') }}</p>
        @endif

        @if (session('contact_error'))
            <p role="alert" class="mb-6 border border-primary px-4 py-3 text-fluid-body text-primary">{{ session('contact_error') }}</p>
        @endif

        <form method="POST" action="{{ $action }}" novalidate class="space-y-5">
            @csrf

            {{-- Honeypot: hidden from people and screen readers --}}
            <div class="absolute -left-[9999px]" aria-hidden="true">
                <label for="{{ $id }}-website">Website</label>
                <input type="text" id="{{ $id }}-website" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="{{ $id }}-name" class="{{ $label }}">Name</label>
                    <input
                        type="text" id="{{ $id }}-name" name="name" value="{{ old('name') }}"
                        required maxlength="100" autocomplete="name"
                        @error('name') aria-invalid="true" aria-describedby="{{ $id }}-name-error" @enderror
                        class="{{ $field }}"
                    >
                    @error('name')<p id="{{ $id }}-name-error" class="{{ $error }}">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="{{ $id }}-email" class="{{ $label }}">Email</label>
                    <input
                        type="email" id="{{ $id }}-email" name="email" value="{{ old('email') }}"
                        required maxlength="150" autocomplete="email"
                        @error('email') aria-invalid="true" aria-describedby="{{ $id }}-email-error" @enderror
                        class="{{ $field }}"
                    >
                    @error('email')<p id="{{ $id }}-email-error" class="{{ $error }}">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="{{ $id }}-phone" class="{{ $label }}">Phone <span class="text-muted">(optional)</span></label>
                <input
                    type="tel" id="{{ $id }}-phone" name="phone" value="{{ old('phone') }}"
                    maxlength="30" autocomplete="tel"
                    @error('phone') aria-invalid="true" aria-describedby="{{ $id }}-phone-error" @enderror
                    class="{{ $field }}"
                >
                @error('phone')<p id="{{ $id }}-phone-error" class="{{ $error }}">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="{{ $id }}-message" class="{{ $label }}">Message</label>
                <textarea
                    id="{{ $id }}-message" name="message" rows="5"
                    required minlength="10" maxlength="2000"
                    @error('message') aria-invalid="true" aria-describedby="{{ $id }}-message-error" @enderror
                    class="{{ $field }}"
                >{{ old('message') }}</textarea>
                @error('message')<p id="{{ $id }}-message-error" class="{{ $error }}">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn-outline inline-block">Send Message</button>
        </form>
    </div>
@endif