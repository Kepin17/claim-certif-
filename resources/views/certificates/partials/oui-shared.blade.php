<style>
    /* ── ONE UI 8.5 – Shared ── */
    .oui-page {
        min-height: calc(100vh - 64px);
        background: #F2F3F5;
        padding: 0 0 48px;
    }

    .oui-hero {
        background: #ffffff;
        padding: 28px 24px 24px;
        border-bottom: none;
    }
    .oui-hero-inner {
        max-width: 680px;
        margin: 0 auto;
    }
    .oui-hero-inner.wide {
        max-width: 1060px;
    }

    .oui-back {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: #3478F6;
        text-decoration: none;
        margin-bottom: 18px;
        transition: opacity 0.15s;
    }
    .oui-back:hover { opacity: 0.72; }
    .oui-back svg { width: 16px; height: 16px; }

    .oui-page-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #3478F6;
        margin-bottom: 6px;
    }
    .oui-page-title {
        font-size: 30px;
        font-weight: 700;
        color: #1C1C1E;
        letter-spacing: -0.5px;
        line-height: 1.15;
        margin-bottom: 8px;
    }
    .oui-page-desc {
        font-size: 14px;
        color: #8E8E93;
        line-height: 1.55;
        max-width: 520px;
    }

    .oui-search-wrap {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .oui-search-field {
        flex: 1;
        display: flex;
        align-items: center;
        background: #F2F3F5;
        border: 1.5px solid transparent;
        border-radius: 16px;
        padding: 0 16px;
        gap: 10px;
        height: 52px;
        transition: border-color 0.18s, background 0.18s;
    }
    .oui-search-field:focus-within {
        background: #fff;
        border-color: #3478F6;
    }
    .oui-search-field svg {
        width: 17px;
        height: 17px;
        color: #8E8E93;
        flex-shrink: 0;
    }
    .oui-search-field input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 15px;
        color: #1C1C1E;
        outline: none;
        font-family: inherit;
    }
    .oui-search-field input::placeholder { color: #AEAEB2; }
    .oui-search-btn {
        height: 52px;
        padding: 0 22px;
        background: #3478F6;
        color: #fff;
        border: none;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
        font-family: inherit;
        flex-shrink: 0;
    }
    .oui-search-btn:hover  { background: #2563EB; }
    .oui-search-btn:active { transform: scale(0.97); }

    .oui-count-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        border: 1.5px solid #E5E5EA;
        border-radius: 50px;
        padding: 5px 14px 5px 10px;
        font-size: 13px;
        font-weight: 500;
        color: #3C3C43;
    }
    .oui-count-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #3478F6;
        flex-shrink: 0;
    }

    .oui-empty {
        background: #fff;
        border-radius: 22px;
        padding: 48px 24px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .oui-empty-icon {
        width: 64px;
        height: 64px;
        background: #F2F3F5;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .oui-empty-icon svg {
        width: 28px;
        height: 28px;
        color: #AEAEB2;
    }
    .oui-empty-title {
        font-size: 17px;
        font-weight: 700;
        color: #1C1C1E;
        margin-bottom: 6px;
    }
    .oui-empty-desc {
        font-size: 13.5px;
        color: #8E8E93;
        line-height: 1.5;
    }

    .oui-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .oui-pagination a,
    .oui-pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }
    .oui-pagination a {
        background: #fff;
        color: #3478F6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07);
    }
    .oui-pagination a:hover { background: #EBF2FF; }
    .oui-pagination span.oui-page-active {
        background: #3478F6;
        color: #fff;
        box-shadow: 0 2px 8px rgba(52,120,246,0.28);
        cursor: default;
    }
    .oui-pagination span.oui-page-disabled {
        background: #F2F3F5;
        color: #AEAEB2;
        cursor: default;
    }
    .oui-pagination-info {
        text-align: center;
        font-size: 12px;
        color: #AEAEB2;
        font-weight: 500;
        margin-top: 8px;
    }

    .oui-section {
        max-width: 1060px;
        margin: 20px auto 0;
        padding: 0 24px;
    }
    .oui-section.narrow {
        max-width: 520px;
    }

    .oui-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 16px;
        align-items: start;
    }

    .oui-card {
        background: #ffffff;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
    }
    .oui-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #1C1C1E;
        margin-bottom: 4px;
    }
    .oui-card-sub {
        font-size: 13px;
        color: #8E8E93;
        margin-bottom: 22px;
        line-height: 1.45;
    }

    .oui-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-size: 13.5px;
        line-height: 1.45;
    }
    .oui-alert svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
    .oui-alert-success { background: #E6FAF0; color: #1A7A40; }
    .oui-alert-error { background: #FFEEED; color: #B02020; }
    .oui-alert ul { margin: 8px 0 0 18px; font-size: 13px; }

    .oui-section-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F2F3F5;
    }
    .oui-section-num {
        width: 28px;
        height: 28px;
        background: #3478F6;
        color: #fff;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .oui-section-head h3 {
        font-size: 15px;
        font-weight: 700;
        color: #1C1C1E;
        line-height: 1.2;
    }
    .oui-section-head p {
        font-size: 12.5px;
        color: #8E8E93;
        margin-top: 2px;
        font-weight: 400;
    }

    .oui-form-block { margin-bottom: 24px; }
    .oui-form-block:last-of-type { margin-bottom: 0; }

    .oui-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .oui-field { margin-bottom: 14px; }
    .oui-field:last-child { margin-bottom: 0; }

    .oui-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #8E8E93;
        margin-bottom: 8px;
    }
    .oui-label .req { color: #FF3B30; margin-left: 2px; text-transform: none; }

    .oui-input,
    .oui-select,
    .oui-textarea {
        width: 100%;
        font-family: inherit;
        font-size: 15px;
        color: #1C1C1E;
        background: #F2F3F5;
        border: 1.5px solid transparent;
        border-radius: 14px;
        padding: 14px 16px;
        outline: none;
        transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
    }
    .oui-input:focus,
    .oui-select:focus,
    .oui-textarea:focus {
        background: #fff;
        border-color: #3478F6;
        box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
    }
    .oui-input::placeholder,
    .oui-textarea::placeholder { color: #AEAEB2; }
    .oui-textarea { resize: vertical; min-height: 100px; line-height: 1.5; }
    .oui-hint {
        font-size: 12px;
        color: #AEAEB2;
        margin-top: 6px;
    }

    .oui-radio-list { display: flex; flex-direction: column; gap: 10px; }
    .oui-radio-option {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 16px;
        background: #F2F3F5;
        border: 1.5px solid transparent;
        border-radius: 16px;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
    }
    .oui-radio-option:has(input:checked) {
        background: #EBF2FF;
        border-color: #3478F6;
    }
    .oui-radio-option input {
        width: 18px;
        height: 18px;
        accent-color: #3478F6;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .oui-radio-title {
        font-size: 14px;
        font-weight: 600;
        color: #1C1C1E;
    }
    .oui-radio-sub {
        font-size: 12px;
        color: #8E8E93;
        margin-top: 2px;
    }

    .oui-actions {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #F2F3F5;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .oui-btn-primary {
        width: 100%;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #3478F6;
        color: #fff;
        border: none;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
        box-shadow: 0 2px 10px rgba(52,120,246,0.28);
    }
    .oui-btn-primary:hover { background: #2563EB; }
    .oui-btn-primary:active { transform: scale(0.98); }

    .oui-note {
        text-align: center;
        font-size: 13px;
        color: #8E8E93;
    }
    .oui-note a {
        color: #3478F6;
        font-weight: 600;
        text-decoration: none;
    }
    .oui-note a:hover { text-decoration: underline; }

    /* Event chip in hero */
    .oui-event-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        background: #EBF2FF;
        border: 1.5px solid rgba(52,120,246,0.2);
        border-radius: 50px;
        padding: 8px 16px 8px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #1A54C4;
    }
    .oui-event-chip svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* Sidebar */
    .oui-side-card { margin-bottom: 0; }
    .oui-side-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8E8E93;
        margin-bottom: 16px;
    }
    .oui-step {
        display: flex;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 14px;
        border-bottom: 1px solid #F2F3F5;
    }
    .oui-step:last-child {
        padding-bottom: 0;
        margin-bottom: 0;
        border-bottom: none;
    }
    .oui-step-num {
        width: 26px;
        height: 26px;
        background: #EBF2FF;
        color: #3478F6;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .oui-step h5 {
        font-size: 13.5px;
        font-weight: 600;
        color: #1C1C1E;
        margin-bottom: 2px;
    }
    .oui-step p {
        font-size: 12.5px;
        color: #8E8E93;
        line-height: 1.4;
    }

    .oui-link-card {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 16px;
        margin-top: 14px;
        background: #3478F6;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(52,120,246,0.28);
        transition: background 0.15s, transform 0.1s;
    }
    .oui-link-card:hover { background: #2563EB; color: #fff; }
    .oui-link-card:active { transform: scale(0.98); }

    .oui-side-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .oui-link-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px 16px;
        background: #fff;
        color: #3478F6;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 16px;
        border: 1.5px solid #E5E5EA;
        transition: background 0.15s, border-color 0.15s;
    }
    .oui-link-secondary:hover {
        background: #EBF2FF;
        border-color: rgba(52,120,246,0.25);
        color: #3478F6;
    }

    .oui-hero-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }
    .oui-hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: #F2F3F5;
        border-radius: 50px;
        font-size: 12.5px;
        font-weight: 600;
        color: #3C3C43;
    }
    .oui-hero-pill svg {
        width: 14px;
        height: 14px;
        color: #3478F6;
        flex-shrink: 0;
    }

    .oui-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 16px;
        flex-shrink: 0;
    }
    .oui-info-card {
        background: #fff;
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .oui-info-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .oui-info-card-icon.blue { background: #EBF2FF; color: #3478F6; }
    .oui-info-card-icon.green { background: #E6FAF0; color: #30D158; }
    .oui-info-card-icon.orange { background: #FFF3E0; color: #FF9F0A; }
    .oui-info-card h3 {
        font-size: 14px;
        font-weight: 700;
        color: #1C1C1E;
        margin-bottom: 6px;
    }
    .oui-info-card p {
        font-size: 12.5px;
        color: #8E8E93;
        line-height: 1.5;
    }

    .oui-tip-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .oui-tip-list li {
        display: flex;
        gap: 10px;
        font-size: 13px;
        color: #3C3C43;
        line-height: 1.45;
    }
    .oui-tip-list li svg {
        width: 16px;
        height: 16px;
        color: #3478F6;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .oui-status-list { display: flex; flex-direction: column; gap: 10px; }
    .oui-status-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        background: #F2F3F5;
        border-radius: 12px;
    }
    .oui-status-row .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }
    .oui-status-row strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1C1C1E;
        margin-bottom: 2px;
    }
    .oui-status-row span {
        font-size: 12px;
        color: #8E8E93;
        line-height: 1.4;
    }

    .oui-faq-item {
        padding: 12px 0;
        border-bottom: 1px solid #F2F3F5;
    }
    .oui-faq-item:last-child { border-bottom: none; padding-bottom: 0; }
    .oui-faq-item strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1C1C1E;
        margin-bottom: 4px;
    }
    .oui-faq-item p {
        font-size: 12.5px;
        color: #8E8E93;
        line-height: 1.45;
        margin: 0;
    }

    @media (max-width: 900px) {
        .oui-layout { grid-template-columns: 1fr; }
        .oui-side-col { order: -1; }
        .oui-info-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 540px) {
        .oui-page-title { font-size: 24px; }
        .oui-hero { padding: 24px 16px 20px; }
        .oui-section { padding: 0 16px; }
        .oui-grid-2 { grid-template-columns: 1fr; }
        .oui-card { padding: 20px; border-radius: 18px; }
    }
</style>
