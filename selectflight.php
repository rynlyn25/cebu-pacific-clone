<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// FIX: If the user has no account/is not logged in, boot them to the login page immediately.
if (!$isLoggedIn) {
    header("Location: login.html"); 
    exit();
}

$initials = $isLoggedIn ? strtoupper(substr($_SESSION['first_name'], 0, 1) . substr($_SESSION['last_name'], 0, 1)) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Booking System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sql.js/1.5.0/sql-wasm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<style>
* {
  box-sizing: border-box;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
h1, h2, h3, .header, .flight-option, .search-btn, .continue-btn, .price-amount {
  font-family: 'Poppins', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
body {
  margin: 0;
  padding: 0;
  background-color: #f7f9fa;
  color: #333;
}
/* Views */
.view-section {
  display: none;
}
.view-section.active-view {
  display: block;
}
/* SEARCH PAGE STYLES */
.header {
  background-color: #FFD200;
  color: #0042ad;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 0;
  font-weight: 700;
  font-size: 18px;
}
.header-content {
  max-width: 950px;
  width: 100%;
  margin: 0 auto;
  padding: 0 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.header .close-btn {
  font-size: 22px;
  cursor: pointer;
  color: #0042ad;
  font-weight: 400;
}
.container {
  max-width: 950px;
  margin: 40px auto;
  background: #ffffff;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  position: relative;
}
h2 {
  font-size: 26px;
  color: #111;
  margin-bottom: 35px;
  font-weight: 700;
  letter-spacing: -0.3px;
}
.options-row {
  display: flex;
  align-items: center;
  margin-bottom: 30px;
  border-bottom: 1px solid #eaeaea;
  padding-bottom: 20px;
}
.flight-option {
  display: flex;
  align-items: center;
  font-weight: 700;
  color: #0b5cab;
  margin-right: 40px;
  font-size: 14px;
}
.flight-option span {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #FFCC00;
  color: #fff;
  margin-right: 8px;
  font-size: 11px;
  line-height: 1;
}
.divider {
  width: 1px;
  height: 24px;
  background-color: #ddd;
  margin-right: 40px;
}
.trip-type-container {
  position: relative;
  display: inline-block;
}
.trip-type {
  font-size: 14px;
  color: #333;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
}
.trip-type::after {
  content: " ▼";
  font-size: 9px;
  margin-left: 6px;
  color: #666;
}
.trip-dropdown {
  display: none;
  position: absolute;
  top: calc(100% + 8px);
  left: 0;
  background: #ffffff;
  border: 1px solid #dcdcdc;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  z-index: 1000;
  width: 140px;
}
.trip-dropdown.active {
  display: block;
}
.trip-dropdown-item {
  padding: 10px 14px;
  font-size: 14px;
  color: #333;
  cursor: pointer;
  font-weight: 600;
}
.trip-dropdown-item:hover {
  background-color: #f0f8ff;
}
.trip-dropdown-item.secondary {
  color: #333;
  font-weight: 600;
  border-top: 1px solid #eaeaea;
}
.trip-dropdown-item.secondary:hover {
  color: #007aff;
}
.form-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 20px;
}
.form-group {
  display: flex;
  flex-direction: column;
  position: relative;
}
label {
  font-size: 11px;
  color: #666;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 600;
}
.input-box {
  position: relative;
  display: flex;
  align-items: center;
  border: 1px solid #dcdcdc;
  border-radius: 4px;
  background-color: #fff;
  padding: 10px 12px;
  height: 46px;
  cursor: pointer;
}
.input-box.active-tab {
  border-color: #00a2ed;
  box-shadow: 0 0 0 1px #00a2ed;
}
.input-box input {
  border: none;
  outline: none;
  width: 100%;
  font-size: 14px;
  color: #333;
  background: transparent;
  cursor: pointer;
}
.input-box input::placeholder {
  color: #aaa;
}
.input-box select {
  border: none;
  outline: none;
  width: 100%;
  font-size: 14px;
  color: #333;
  background: transparent;
  appearance: none;
  cursor: pointer;
}
.form-grid.select-grid .input-box {
  background-image: url("data:image/svg+xml;utf8,<svg fill='%23666' height='10' viewBox='0 0 24 24' width='10' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
}
.input-box .icon-right {
  color: #888;
  font-size: 14px;
  cursor: pointer;
  margin-left: 8px;
}
.input-box .swap-icon {
  background: #f0f0f0;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  left: -12px;
  z-index: 2;
  cursor: pointer;
  border: 1px solid #dcdcdc;
  color: #666;
  font-size: 11px;
}
.sub-label {
  font-size: 11px;
  color: #888;
  margin-top: 4px;
}
.button-container {
  display: flex;
  justify-content: flex-end;
  margin-top: 30px;
}
.search-btn {
  background-color: #00a2ed;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 12px 28px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.25s;
}
.search-btn:hover {
  background-color: #008bbd;
}
.search-btn:disabled {
  background-color: #cfd6db;
  color: #8a949c;
  cursor: not-allowed;
}
.search-btn:disabled:hover {
  background-color: #cfd6db;
}
.location-modal {
  display: none;
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  width: 550px;
  background: #ffffff;
  border: 1px solid #dcdcdc;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  z-index: 1000;
}
.location-modal.active {
  display: flex;
}
.modal-left {
  width: 180px;
  background-color: #f7f9fa;
  border-right: 1px solid #eaeaea;
  padding: 15px 0;
}
.modal-left-item {
  display: flex;
  align-items: center;
  padding: 10px 15px;
  font-size: 13px;
  color: #333;
  cursor: pointer;
  background-color: #fff;
  border-left: 3px solid #00a2ed;
}
.modal-left-item span {
  color: #00a2ed;
  margin-right: 8px;
}
.modal-left-item .arrow {
  margin-left: auto;
  color: #00a2ed;
  font-weight: bold;
}
.modal-right {
  flex: 1;
  padding: 20px;
  position: relative;
  max-height: 320px;
  overflow-y: auto;
}
.modal-right h4 {
  margin: 0 0 15px 0;
  font-size: 14px;
  color: #111;
  font-weight: 700;
}
.country-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  row-gap: 12px;
  column-gap: 20px;
}
.country-item {
  font-size: 13px;
  color: #333;
  cursor: pointer;
  font-weight: 600;
}
.country-item:hover {
  color: #007aff;
}
.city-item {
  font-size: 13px;
  color: #333;
  cursor: pointer;
  margin-top: 10px;
  margin-left: 15px;
  display: none;
}
.city-item:hover {
  color: #007aff;
}
.city-item.show {
  display: block;
}
.calendar-modal {
  display: none;
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  width: 680px;
  background: #ffffff;
  border: 1px solid #dcdcdc;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  z-index: 1000;
  padding: 20px;
}
.calendar-modal.active {
  display: block;
}
.calendar-container {
  display: flex;
  gap: 20px;
  user-select: none;
}
.calendar-month {
  flex: 1;
}
.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 700;
  font-size: 15px;
  color: #111;
  margin-bottom: 15px;
  padding: 0 10px;
}
.calendar-header button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 14px;
  color: #00a2ed;
  font-weight: bold;
}
.calendar-weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  font-size: 11px;
  color: #666;
  font-weight: 600;
  margin-bottom: 8px;
}
.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  row-gap: 4px;
}
.calendar-day {
  aspect-ratio: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  color: #333;
  cursor: pointer;
  border-radius: 50%;
  margin: auto;
  width: 32px;
  height: 32px;
}
.calendar-day:hover:not(.empty):not(.disabled) {
  background-color: #f0f0f0;
}
.calendar-day.empty {
  cursor: default;
}
.calendar-day.disabled {
  color: #ccc;
  cursor: not-allowed;
}
.calendar-day.selected-start,
.calendar-day.selected-end {
  background-color: #00a2ed !important;
  color: #fff !important;
  font-weight: 600;
}
.calendar-day.in-range {
  background-color: #e6f4fb;
  border-radius: 0;
}
.calendar-footer {
  display: flex;
  justify-content: flex-end;
  margin-top: 20px;
  border-top: 1px solid #eaeaea;
  padding-top: 15px;
}
.select-dates-btn {
  background-color: #b3d7e5;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.25s;
}
.select-dates-btn.active-confirm {
  background-color: #00a2ed;
}

/* SELECT FLIGHT PAGE STYLES */
.flight-summary-strip {
  background-color: #002244;
  color: #ffffff;
  padding: 12px 24px;
  font-size: 13px;
}
.flight-summary-content {
  max-width: 900px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.summary-left {
  display: flex;
  align-items: center;
  gap: 16px;
}
.back-link-btn {
  color: #ffffff;
  text-decoration: none;
  font-weight: 600;
  font-size: 13px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
  background: transparent;
  border: none;
  padding: 0;
}
.back-link-btn:hover {
  text-decoration: underline;
}
.summary-route {
  font-weight: 700;
  font-size: 15px;
}
.summary-details {
  color: #d0d7de;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 12px;
}
.modify-search-btn {
  background-color: transparent;
  border: 1px solid #00a2ed;
  color: #00a2ed;
  padding: 6px 14px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
}
.modify-search-btn:hover {
  background-color: rgba(0, 162, 237, 0.1);
}
.progress-bar {
  background: #f7d417;
  padding: 22px 0 18px;
}
.progress-steps {
  max-width: 720px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  position: relative;
  flex: 1;
}
.step-circle {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: #fff;
  border: 2px solid #1a3e6f;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  color: #1a3e6f;
  z-index: 2;
}
.step-label {
  font-size: 12.5px;
  font-weight: 700;
  color: #1a3e6f;
}
.step::after {
  content: "";
  position: absolute;
  top: 17px;
  left: 50%;
  width: 100%;
  height: 0;
  border-top: 2px dashed #1a3e6f;
  z-index: 1;
}
.step:last-child::after {
  display: none;
}
.page {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px 24px 60px;
}
.jump-to {
  font-size: 12px;
  color: #444;
  margin-bottom: 18px;
}
.jump-to b {
  font-weight: 700;
}
.jump-to a {
  color: #0b5cab;
  text-decoration: none;
  margin-left: 4px;
  font-weight: 700;
}
.section-label {
  font-size: 13px;
  color: #333;
  margin-bottom: 6px;
}
.route-title {
  font-size: 24px;
  font-weight: 800;
  color: #1a1a1a;
  margin: 0 0 16px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.route-title .city-code {
  font-weight: 400;
  font-size: 20px;
  color: #444;
  margin-right: 6px;
}
.route-title .plane {
  color: #0b5cab;
  font-size: 20px;
}
.date-strip {
  display: flex;
  align-items: stretch;
  background: #fff;
  border: 1px solid #e0e0e0;
  margin-bottom: 18px;
}
/* Disables date/filter/sort controls for a section once a flight card
   in that section has been selected (inserted). */
.date-strip.controls-locked,
.filter-row.controls-locked {
  pointer-events: none;
  opacity: 0.5;
}
.date-nav-btn {
  background: #fff;
  border: none;
  width: 32px;
  font-size: 16px;
  color: #666;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}
.date-nav-btn:hover {
  background: #f0f0f0;
}
.date-cell.past-date {
  color: #ccc;
  cursor: not-allowed;
  background: #fafafa;
}
.date-cell.past-date:hover {
  background: #fafafa;
}
.date-cell.past-date .date-price {
  color: #ccc;
}
.date-nav-btn.disabled {
  color: #ddd;
  cursor: not-allowed;
  pointer-events: none;
}
.date-cells {
  display: flex;
  flex: 1;
}
.date-cell {
  flex: 1;
  padding: 8px 4px;
  text-align: center;
  border-left: 1px solid #eee;
  cursor: pointer;
  font-size: 11.5px;
  color: #555;
  background: #fff;
  transition: background 0.15s;
}
.date-cell:hover {
  background: #f9f9f9;
}
.date-cell.active {
  background: #0073e6;
  color: #fff;
  border-left-color: #0073e6;
}
.date-cell.active .date-price {
  color: #fff;
}
.date-day {
  font-weight: 600;
  line-height: 1.2;
}
.date-price {
  font-size: 11px;
  color: #222;
  margin-top: 3px;
}
.filter-row {
  display: flex;
  gap: 12px;
  margin-bottom: 18px;
}
.filter-btn {
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px 16px;
  font-size: 12.5px;
  font-weight: 600;
  color: #333;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}
.filter-btn:hover {
  border-color: #999;
}
.filter-btn span.arrow {
  font-size: 9px;
  color: #666;
}
.sort-btn {
  margin-left: auto;
}
.sort-dropdown-wrapper {
  position: relative;
  margin-left: auto;
}
.sort-menu {
  display: none;
  position: absolute;
  right: 0;
  top: calc(100% + 4px);
  background: #fff;
  border: 1px solid #dcdcdc;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  z-index: 1000;
  min-width: 180px;
}
.sort-menu.active {
  display: block;
}
.sort-option {
  padding: 10px 14px;
  font-size: 13px;
  color: #333;
  cursor: pointer;
  font-weight: 600;
}
.sort-option:hover {
  background-color: #f0f8ff;
  color: #007aff;
}
.filter-dropdown-wrapper {
  position: relative;
}
.time-filter-menu,
.stops-filter-menu {
  display: none;
  position: absolute;
  left: 0;
  top: calc(100% + 6px);
  background: #fff;
  border: 1px solid #dcdcdc;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
  border-radius: 6px;
  z-index: 1000;
  width: 300px;
  padding: 16px;
}
.time-filter-menu.active,
.stops-filter-menu.active {
  display: block;
}
.time-filter-tabs {
  display: flex;
  border: 1px solid #00a2ed;
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: 14px;
}
.time-tab {
  flex: 1;
  background: #fff;
  border: none;
  padding: 8px 10px;
  font-size: 12.5px;
  font-weight: 700;
  color: #00a2ed;
  cursor: pointer;
}
.time-tab.active {
  background: #00a2ed;
  color: #fff;
}
.time-filter-options {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 16px;
}
.time-filter-option {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: #333;
  font-weight: 600;
  cursor: pointer;
}
.time-filter-option input {
  width: 15px;
  height: 15px;
  cursor: pointer;
  accent-color: #00a2ed;
}
.time-filter-actions {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.filter-reset-btn {
  background: none;
  border: none;
  color: #00a2ed;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  padding: 8px 4px;
}
.filter-reset-btn:hover {
  text-decoration: underline;
}
.filter-apply-btn {
  background-color: #00a2ed;
  color: #fff;
  border: none;
  border-radius: 20px;
  padding: 9px 26px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  transition: background-color 0.2s;
}
.filter-apply-btn:hover {
  background-color: #008bbd;
}
.flight-card {
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 2px;
  padding: 18px 20px;
  margin-bottom: 14px;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
}
.flight-left {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.flight-times {
  display: flex;
  align-items: baseline;
  gap: 12px;
}
.time-group {
  display: flex;
  align-items: baseline;
  gap: 4px;
}
.time {
  font-size: 20px;
  font-weight: 800;
  color: #111;
}
.period {
  font-size: 11px;
  font-weight: 700;
  color: #666;
  letter-spacing: 0.3px;
  margin-left: -2px;
}
.city {
  font-size: 13px;
  font-weight: 700;
  color: #333;
}
.arrow-sep {
  color: #888;
  font-size: 14px;
}
.flight-meta {
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 12px;
  color: #555;
}
.flight-num {
  color: #0b5cab;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
}
.flight-num::after {
  content: " ▼";
  font-size: 8px;
  color: #0b5cab;
}
.direct-badge {
  color: #2e7d32;
  font-weight: 600;
}
.duration {
  color: #666;
}
.flight-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 8px;
}
.price-label {
  font-size: 11px;
  color: #777;
}
.price-amount {
  font-size: 22px;
  font-weight: 800;
  color: #111;
}
.price-amount .currency {
  font-size: 15px;
  font-weight: 700;
  margin-right: 2px;
}
.select-btn {
  background: #f7d417;
  color: #1a3e6f;
  border: none;
  border-radius: 4px;
  padding: 9px 24px;
  font-size: 13.5px;
  font-weight: 800;
  cursor: pointer;
  transition: background 0.15s;
}
.select-btn:hover {
  background: #e6c400;
}
.no-flights-msg {
  display: none;
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 2px;
  padding: 40px 36px;
  align-items: center;
  gap: 28px;
  margin-bottom: 14px;
}
.no-flights-msg .no-flights-icon {
  flex-shrink: 0;
  width: 110px;
  height: 90px;
}
.no-flights-msg .no-flights-icon svg {
  width: 100%;
  height: 100%;
}
.no-flights-msg .no-flights-text {
  text-align: left;
}
.no-flights-msg .no-flights-title {
  font-size: 15px;
  font-weight: 800;
  color: #222;
  margin-bottom: 6px;
}
.no-flights-msg .no-flights-desc {
  font-size: 13.5px;
  color: #666;
  font-weight: 400;
  line-height: 1.5;
  max-width: 520px;
}
.date-cell .date-price.no-flights-label {
  color: #b71c1c;
  font-weight: 700;
}
.date-cell.active .date-price.no-flights-label {
  color: #fff;
}
/* ---------- GUEST-INFO STYLE HEADER / STEPPER (inserted, namespaced to avoid clashing with existing .header) ---------- */
.gh-header{
  background:#FFD200;
  padding:22px 0 16px;
}
.gh-stepper{
  max-width:900px;
  margin:0 auto;
  display:flex;
  align-items:flex-start;
  justify-content:center;
}
.gh-step{
  display:flex;
  flex-direction:column;
  align-items:center;
  position:relative;
  width:150px;
}
.gh-step .gh-circle-badge{
  padding:5px;
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
}
.gh-step .gh-circle{
  width:30px;height:30px;border-radius:50%;
  background:#fff;
  border:2px solid #12395B;
  display:flex;align-items:center;justify-content:center;
  color:#12395B;
  z-index:2;
}
.gh-step.gh-done .gh-circle, .gh-step.gh-active .gh-circle{
  background:#12395B;
  color:#fff;
}
.gh-step .gh-circle svg{ width:15px; height:15px; }
.gh-step label{
  margin-top:6px;
  font-size:12.5px;
  font-weight:bold;
  color:#12395B;
}
.gh-step:not(.gh-done):not(.gh-active) label{ color:#0072CE; font-weight:normal;}
.gh-connector{
  position:absolute;
  top:19px; left:calc(-75px + 15px);
  width:150px;height:0;
  border-top:2px dotted #ffffff;
  z-index:1;
}
.gh-step.gh-active .gh-connector{
  border-top:2px dotted #12395B;
}
/* ---------- CONTINUE BAR (inserted) ---------- */
.continue-bar{
  position: sticky;
  bottom: 0;
  left: 0;
  right: 0;
  background: #fff;
  border-top: 1px solid #e0e0e0;
  padding: 14px 24px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 14px;
  box-shadow: 0 -2px 8px rgba(0,0,0,0.06);
  z-index: 50;
}
.continue-bar .continue-hint{
  margin-right: auto;
  font-size: 13px;
  color: #555;
}
.continue-btn{
  background: #FFD200;
  color: #12395B;
  font-weight: bold;
  font-size: 15px;
  border: none;
  border-radius: 6px;
  padding: 12px 40px;
  cursor: pointer;
  transition: background 0.15s ease;
}
.continue-btn:hover:not(:disabled){
  background: #f0c600;
}
.continue-btn:disabled{
  background: #e0e0e0;
  color: #999;
  cursor: not-allowed;
}
.flight-card.flight-card-selected{
  border: 2px solid #12395B;
  box-shadow: 0 0 0 1px #12395B inset;
}
/* ---------- SELECTED FLIGHT COLLAPSE (inserted) ---------- */
.flight-card.fc-hidden {
  display: none;
}
.flight-card.flight-card-selected {
  position: relative;
  overflow: visible;
}
.selected-check-badge {
  position: absolute;
  top: -10px;
  right: -10px;
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: #00a2ed;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  font-weight: 800;
  box-shadow: 0 1px 4px rgba(0,0,0,0.25);
}
.select-btn.change-btn {
  background: #fff;
  color: #0b5cab;
  border: 1.5px solid #0b5cab;
}
.select-btn.change-btn:hover {
  background: #f0f8ff;
}

/* ===== Guest Details styles (merged from guestinfos.html, scoped to #guestView) ===== */
  :root{
    --yellow:#FFD200;
    --blue-link:#0072CE;
    --blue-dark:#12395B;
    --text-dark:#1a1a1a;
    --text-gray:#6b7280;
    --border:#d1d5db;
    --error-red:#e02020;
    --info-blue:#e8f4fd;
  }#guestView * {box-sizing:border-box;}#guestView body {
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f2f2f2;
    color:var(--text-dark);
  }

  /* ---------- HEADER / STEPPER ---------- */#guestView .gi-header {
    background:var(--yellow);
    padding:22px 0 16px;
  }#guestView .stepper {
    max-width:900px;
    margin:0 auto;
    display:flex;
    align-items:flex-start;
    justify-content:center;
  }#guestView .gi-step {
    display:flex;
    flex-direction:column;
    align-items:center;
    position:relative;
    width:150px;
  }#guestView .gi-step .circle-badge {
    padding:5px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
  }#guestView .gi-step .circle {
    width:30px;height:30px;border-radius:50%;
    background:#fff;
    border:2px solid var(--blue-dark);
    display:flex;align-items:center;justify-content:center;
    color:var(--blue-dark);
    z-index:2;
  }#guestView .gi-step.done .circle, #guestView .gi-step.active .circle {
    background:var(--blue-dark);
    color:#fff;
  }#guestView .gi-step .circle svg { width:15px; height:15px; }#guestView .gi-step label {
    margin-top:6px;
    font-size:12.5px;
    font-weight:bold;
    color:var(--blue-dark);
  }#guestView .gi-step:not(.done):not(.active) label { color:var(--blue-link); font-weight:normal;}#guestView .connector {
    position:absolute;
    top:19px; left:calc(-75px + 15px);
    width:150px;height:0;
    border-top:2px dotted #ffffff;
    z-index:1;
  }#guestView .gi-step.active .connector {
    border-top:2px dotted var(--blue-dark);
  }#guestView .gi-step:first-child .connector {display:none;}

  /* ---------- PAGE CONTENT ---------- */#guestView .page-intro {
    max-width:900px;
    margin:18px auto 4px;
    padding:0 20px;
    font-size:13px;
    color:#333;
  }#guestView h1.page-title {
    max-width:900px;
    margin:2px auto 18px;
    padding:0 20px;
    font-size:26px;
  }#guestView .content-wrap {
    max-width:900px;
    margin:0 auto 40px;
    padding:0 20px;
    display:flex;
    gap:20px;
  }#guestView .guest-tabs {
    width:180px;
    background:#fff;
    border-radius:4px;
    box-shadow:0 1px 3px rgba(0,0,0,0.12);
  }#guestView .guest-tab {
    padding:14px 16px;
    border-left:4px solid var(--blue-link);
    font-size:13px;
    cursor:pointer;
  }#guestView .guest-tab .num { color:var(--text-gray); font-size:11px; display:block;}#guestView .guest-tab .name { font-weight:bold; color:var(--text-dark);}#guestView .form-card {
    flex:1;
    background:#fff;
    border-radius:4px;
    box-shadow:0 1px 3px rgba(0,0,0,0.12);
    padding:24px 28px;
  }#guestView .bundle-label {
    font-size:11px; font-weight:bold; color:var(--blue-link);
    letter-spacing:.3px;
  }#guestView .bundle-route { font-size:12px; font-weight:bold; margin-top:8px;}#guestView .bundle-fare { font-size:12px; margin-top:2px; display:flex; align-items:center; gap:4px;}#guestView hr.sep { border:none; border-top:1px solid #e5e5e5; margin:14px 0 18px;}#guestView .field-label {
    font-size:12px; font-weight:bold; margin-bottom:6px; display:block;
  }#guestView .req { color:var(--error-red); }#guestView .helper-text { font-size:11.5px; color:#555; margin:-4px 0 12px;}#guestView .row { display:flex; gap:14px; margin-bottom:16px;}#guestView .row > div { flex:1; display:flex; flex-direction:column;}#guestView input[type=text], #guestView input[type=tel], #guestView input[type=email], #guestView input[type=number], #guestView select {
    padding:9px 10px;
    border:1px solid var(--border);
    border-radius:3px;
    font-size:13px;
    width:100%;
    font-family:inherit;
    color:var(--text-dark);
  }#guestView select {
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;
    background-color:#fff;
    background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
    background-repeat:no-repeat;
    background-position:right 10px center;
    background-size:14px;
    padding-right:32px;
    cursor:pointer;
  }#guestView select:disabled { cursor:default; }#guestView select:required:invalid, #guestView select option[value=""] { color:#9aa0a6; }#guestView input:focus, #guestView select:focus {
    outline:none;
    border-color:var(--blue-link);
    box-shadow:0 0 0 2px rgba(0,114,206,0.15);
  }#guestView input.invalid, #guestView select.invalid {
    border-color:var(--error-red);
    border-width:1.5px;
    background-color:#fff5f5;
  }#guestView .error-msg {
    color:var(--error-red);
    font-size:11px;
    margin-top:4px;
    display:none;
    align-items:center;
    gap:6px;
  }#guestView .error-msg.show { display:flex; }#guestView .error-msg.show::before {
    content:"!";
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:14px;height:14px;
    min-width:14px;
    border-radius:50%;
    background:var(--error-red);
    color:#fff;
    font-size:10px;
    font-weight:bold;
    flex-shrink:0;
  }#guestView .checkbox-row {
    display:flex; align-items:center; gap:8px;
    font-size:13px; margin:6px 0;
    text-transform:uppercase;
  }#guestView .checkbox-row input { width:16px;height:16px;}#guestView .no-first-name {
    display:flex; align-items:center; gap:6px;
    font-size:12px; color:#333; margin-top:8px;
  }#guestView .info-icon {
    display:inline-flex; align-items:center; justify-content:center;
    width:14px;height:14px; border-radius:50%;
    background:var(--text-gray); color:#fff; font-size:9px; font-style:normal;
    cursor:default;
  }#guestView .note-box {
    background:var(--info-blue);
    border-radius:4px;
    padding:12px 14px;
    font-size:12px;
    color:#1a1a1a;
    display:flex;
    gap:8px;
    margin-bottom:6px;
  }#guestView .note-box .dot {
    width:16px;height:16px;border-radius:50%;
    background:var(--blue-link); color:#fff;
    font-size:10px; display:flex;align-items:center;justify-content:center;
    flex-shrink:0; margin-top:1px;
  }#guestView .decl-details {
    font-size:12.5px; margin-bottom:10px;
  }#guestView .decl-details b { font-size:13px; }#guestView .decl-details .date { display:block; margin-top:2px; color:#333;}#guestView .decl-row {
    display:flex;
    align-items:flex-start;
    gap:8px;
    margin-bottom:10px;
  }#guestView .decl-row .dropdown {
    flex:1;
    margin-bottom:0;
  }#guestView .decl-remove {
    flex-shrink:0;
    width:22px;height:22px;
    margin-top:6px;
    display:flex;align-items:center;justify-content:center;
    border:none;background:none;
    color:#9aa0a6;
    font-size:18px;
    line-height:1;
    cursor:pointer;
    border-radius:50%;
  }#guestView .decl-remove:hover { color:#d32f2f; background:#fdecea; }#guestView a.add-link {
    color:var(--blue-link);
    font-size:13px;
    font-weight:bold;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:6px;
    cursor:pointer;
  }#guestView a.add-link.hidden { display:none; }#guestView a.add-link .plus {
    width:18px;height:18px;border-radius:50%;
    background:var(--blue-link); color:#fff;
    display:flex;align-items:center;justify-content:center;
    font-size:13px;
  }#guestView .warn-box {
    background:#fdf6e3;
    border-radius:4px;
    padding:12px 14px;
    font-size:11.5px;
    color:#444;
    margin-top:14px;
  }#guestView .warn-box b { font-size:12px; }

  /* ---------- CUSTOM DROPDOWN ---------- */#guestView .dropdown {
    position:relative;
  }#guestView .dropdown-input {
    padding:9px 10px;
    border:1px solid var(--border);
    border-radius:3px;
    font-size:13px;
    width:100%;
    font-family:inherit;
    color:var(--text-dark);
    background:#fff;
    cursor:pointer;
  }#guestView .dropdown-input::placeholder { color:#9aa0a6; }#guestView .dropdown-input:focus, #guestView .dropdown.open .dropdown-input {
    outline:none;
    border-color:var(--blue-link);
    box-shadow:0 0 0 2px rgba(0,114,206,0.15);
  }#guestView .dropdown-list {
    position:absolute;
    top:calc(100% + 2px);
    left:0; right:0;
    background:#fff;
    border:1px solid #e0e0e0;
    border-radius:3px;
    box-shadow:0 4px 12px rgba(0,0,0,0.12);
    max-height:190px;
    overflow-y:auto;
    z-index:20;
    display:none;
    padding:4px 0;
  }#guestView .dropdown.open .dropdown-list { display:block; }#guestView .dropdown-list .opt {
    padding:9px 14px;
    font-size:13px;
    color:var(--text-dark);
    cursor:pointer;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  /* Country code list needs to be wider than its small input so full country names are readable */#guestView #countryCodeList {
    left:0;
    right:auto;
    width:300px;
    max-width:80vw;
  }#guestView #countryCodeList .opt {
    white-space:normal;
    overflow:visible;
    text-overflow:clip;
    line-height:1.3;
  }#guestView .dropdown-list .opt:hover { background:#f2f7fc; }#guestView .dropdown-list .opt.placeholder-opt { color:#9aa0a6; }#guestView .dropdown-list .opt.selected { color:var(--blue-link); font-weight:bold; }

  /* Contact info section */#guestView .contact-section {
    max-width:900px;
    margin:30px auto 60px;
    padding:0 20px;
  }#guestView .contact-section h1 { font-size:24px; margin-bottom:4px;}#guestView .contact-sub { font-size:13px; color:#333; margin-bottom:16px;}#guestView .contact-card {
    background:#fff; border-radius:4px;
    box-shadow:0 1px 3px rgba(0,0,0,0.12);
    padding:26px 28px;
  }#guestView .toggle-row {
    display:flex; align-items:center; gap:10px; margin-bottom:18px;
    font-size:13px; font-weight:bold;
  }#guestView .switch {
    position:relative; width:40px; height:22px;
    display:inline-block;
  }#guestView .switch input { opacity:0; width:0; height:0; }#guestView .slider {
    position:absolute; cursor:pointer; inset:0;
    background:var(--blue-link); border-radius:22px;
    transition:.2s;
  }#guestView .slider:before {
    content:""; position:absolute; height:16px;width:16px;
    left:3px; top:3px; background:#fff; border-radius:50%;
    transition:.2s;
  }#guestView .switch input:checked + .slider { background:var(--blue-link); }#guestView .switch input:checked + .slider:before { transform:translateX(18px); }#guestView .switch input:not(:checked) + .slider { background:#bbb; }#guestView .select-guest-label { font-size:12px; font-weight:bold; margin-bottom:4px;}#guestView select#guestSelect { margin-bottom:20px; color:#999; }#guestView .contact-number-label { font-size:12px; font-weight:bold; margin-bottom:8px; display:block;}#guestView .contact-row { display:flex; align-items:flex-start; gap:14px; margin-bottom:20px;}#guestView .contact-row .cc { width:110px; }#guestView .contact-row .mobile { flex:1; }#guestView .contact-row .field-label { display:flex; align-items:center; height:16px; white-space:nowrap; }#guestView .terms-card {
    background:#fff; border-radius:4px; box-shadow:0 1px 3px rgba(0,0,0,0.12);
    padding:20px 24px; margin-top:16px;
    display:flex; align-items:flex-start; gap:10px;
    font-size:12.5px; color:#333;
    border:1.5px solid transparent;
  }#guestView .terms-card input { margin-top:3px; width:16px;height:16px;}#guestView .terms-card a { color:var(--blue-link); font-weight:bold; text-decoration:none;}#guestView .terms-card.invalid {
    background:#fff5f5;
    border-color:var(--error-red);
  }#guestView .terms-card.invalid input { outline:1.5px solid var(--error-red); outline-offset:1px; }#guestView .actions {
    display:flex; justify-content:flex-end; gap:14px; margin-top:20px;
  }#guestView button {
    font-family:inherit; font-size:14px; font-weight:bold;
    padding:11px 30px; border-radius:24px; cursor:pointer; border:none;
  }#guestView .btn-back {
    background:#fff; color:var(--blue-link); border:1px solid var(--blue-link);
  #guestContinueBtn {
    background-color: #a9cbe8; /* Disabled look by default */
    color: white;
    cursor: not-allowed;
    transition: background-color 0.2s;
}
#guestContinueBtn.enabled {
    background-color: #0072CE !important; /* Cebu Pacific Blue when active */
    cursor: pointer !important;
}
    background:var(--blue-link); color:#fff;
  }#guestView .btn-continue.enabled:hover { background:#005ba3; }

</style>
<style>
/* ===== Duplicate guest-info warning modal (replaces plain browser alert
   for passport/mobile/email duplicate checks) ===== */
.dup-alert-overlay {
  position: fixed;
  inset: 0;
  background: rgba(18, 57, 91, 0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99999;
  padding: 16px;
  animation: dupAlertFadeIn 0.15s ease-out;
  font-family: Arial, Helvetica, sans-serif;
}
.dup-alert-card {
  background: #fff;
  border-radius: 14px;
  padding: 28px 30px 24px;
  max-width: 420px;
  width: 100%;
  text-align: center;
  box-shadow: 0 20px 50px rgba(0,0,0,0.28);
  border-top: 6px solid #FFD200;
  animation: dupAlertPopIn 0.2s cubic-bezier(.34,1.56,.64,1);
}
.dup-alert-icon {
  width: 52px;
  height: 52px;
  line-height: 52px;
  border-radius: 50%;
  background: #FFD200;
  color: #12395B;
  font-size: 26px;
  font-weight: 700;
  margin: 0 auto 14px;
}
.dup-alert-title {
  margin: 0 0 10px;
  font-size: 19px;
  font-weight: 700;
  color: #12395B;
}
.dup-alert-message {
  margin: 0 0 8px;
  font-size: 14.5px;
  line-height: 1.55;
  color: #333;
}
.dup-alert-value {
  color: #12395B;
  font-weight: 700;
  background: #FFF6C9;
  padding: 1px 6px;
  border-radius: 4px;
}
.dup-alert-submessage {
  margin: 0 0 22px;
  font-size: 12.5px;
  color: #6b7280;
}
.dup-alert-btn {
  background: #FFD200;
  color: #12395B;
  border: none;
  padding: 10px 34px;
  border-radius: 24px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.15s ease, transform 0.1s ease;
}
.dup-alert-btn:hover { background: #f0c400; }
.dup-alert-btn:active { transform: scale(0.97); }
@keyframes dupAlertFadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes dupAlertPopIn {
  from { opacity: 0; transform: scale(0.9) translateY(10px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}
</style>
</head>
<body>

<!-- VIEW 1: SEARCH FLIGHT -->
<div id="searchView" class="view-section active-view">
  <!-- Header -->
  <div class="header">
    <div class="header-content">
      <div style="color: #0042ad;">Search Flight</div>
      <div class="close-btn" style="color: #0042ad;">&times;</div>
    </div>
  </div>
  <!-- Container -->
  <div class="container">
    <h2>Hi, where would you like to go?</h2>
    <div class="options-row">
      <div class="flight-option">
        <span>&#9992;</span> Flight
      </div>
      <div class="divider"></div>
      <div class="trip-type-container">
        <div class="trip-type" id="tripTypeBtn">Round-trip</div>
        <div class="trip-dropdown" id="tripDropdown">
          <div class="trip-dropdown-item" id="tripRoundOption">Round-trip</div>
          <div class="trip-dropdown-item secondary" id="tripOneWayOption">One-way</div>
        </div>
      </div>
    </div>
    <!-- First Row of Inputs -->
    <div class="form-grid">
      <div class="form-group">
        <label>From</label>
        <div class="input-box" id="origin-box">
          <input type="text" id="origin-input" placeholder="Select Origin" readonly>
          <span class="icon-right">▼</span>
        </div>
        <!-- Location Dropdown Modal -->
        <div class="location-modal" id="locationModal">
          <div class="modal-left">
            <div class="modal-left-item">
              <span>✈</span> All Locations <span class="arrow">&gt;</span>
            </div>
          </div>
          <div class="modal-right">
            <h4>Country</h4>
            <div class="country-grid">
              <div>
                <div class="country-item" id="australiaBtn">Australia</div>
                <div class="city-item" id="melbourneBtn">Melbourne</div>
                <div class="city-item" id="sydneyBtn">Sydney</div>
              </div>
              <div>
                <div class="country-item" id="chinaBtn">China</div>
                <div class="city-item" id="guangzhouBtn">Guangzhou (Canton)</div>
                <div class="city-item" id="shanghaiBtn">Shanghai</div>
                <div class="city-item" id="shenzhenBtn">Shenzhen</div>
                <div class="city-item" id="xiamenBtn">Xiamen</div>
              </div>
              <div>
                <div class="country-item" id="bruneiBtn">Brunei Darussalam</div>
                <div class="city-item" id="bandarBtn">Bandar Seri Begawan (Brunei)</div>
              </div>
              <div>
                <div class="country-item" id="hongKongBtn">Hong Kong (China)</div>
                <div class="city-item" id="hongKongCityBtn">HongKong</div>
              </div>
              <div>
                <div class="country-item" id="indonesiaBtn">Indonesia</div>
                <div class="city-item" id="baliBtn">Bali (Denpasar)</div>
                <div class="city-item" id="jakartaBtn">Jakarta</div>
              </div>
              <div>
                <div class="country-item" id="japanBtn">Japan</div>
                <div class="city-item" id="fukuokaBtn">Fukuoka</div>
                <div class="city-item" id="nagoyaBtn">Nagoya</div>
                <div class="city-item" id="osakaBtn">Osaka (Kansai)</div>
                <div class="city-item" id="sapporoBtn">Sapporo (New Chitose)</div>
              </div>
              <div>
                <div class="country-item" id="macauBtn">Macau (China)</div>
                <div class="city-item" id="macauCityBtn">Macau</div>
              </div>
              <div>
                <div class="country-item" id="malaysiaBtn">Malaysia</div>
                <div class="city-item" id="kualaLumpurBtn">Kuala Lumpur</div>
              </div>
              <div>
                <div class="country-item" id="philippinesBtn">Philippines</div>
                <div class="city-item" id="bacolodBtn">Bacolod</div>
                <div class="city-item" id="boholBtn">Bohol</div>
                <div class="city-item" id="boracayBtn">Boracay (Caticlan)</div>
                <div class="city-item" id="butuanBtn">Butuan</div>
                <div class="city-item" id="cagayanBtn">Cagayan de Oro</div>
                <div class="city-item" id="calbayogBtn">Calbayog</div>
                <div class="city-item" id="camiguinBtn">Camiguin</div>
                <div class="city-item" id="cauayanBtn">Cauayan</div>
                <div class="city-item" id="cebuBtn">Cebu</div>
                <div class="city-item" id="clarkBtn">Clark</div>
                <div class="city-item" id="coronBtn">Coron (Busuanga)</div>
                <div class="city-item" id="cotabatoBtn">Cotabato</div>
                <div class="city-item" id="davaoBtn">Davao</div>
                <div class="city-item" id="dipologBtn">Dipolog</div>
                <div class="city-item" id="dumagueteBtn">Dumaguete</div>
                <div class="city-item" id="elNidoBtn">El Nido</div>
                <div class="city-item" id="generalSantosBtn">General Santos</div>
                <div class="city-item" id="iloiloBtn">Iloilo</div>
                <div class="city-item" id="kaliboBtn">Kalibo</div>
                <div class="city-item" id="laoagBtn">Laoag</div>
                <div class="city-item" id="legazpiBtn">Legazpi (Daraga)</div>
                <div class="city-item" id="manilaBtn">Manila</div>
                <div class="city-item" id="masbateBtn">Masbate</div>
                <div class="city-item" id="nagaBtn">Naga</div>
                <div class="city-item" id="ozamizBtn">Ozamiz</div>
                <div class="city-item" id="pagadianBtn">Pagadian</div>
                <div class="city-item" id="puertoPrincesaBtn">Puerto Princesa</div>
                <div class="city-item" id="roxasBtn">Roxas</div>
                <div class="city-item" id="sanJoseBtn">San Jose (Mindoro)</div>
                <div class="city-item" id="sanVicenteBtn">San Vicente (Port Barton)</div>
                <div class="city-item" id="siargaoBtn">Siargao</div>
                <div class="city-item" id="surigaoBtn">Surigao</div>
                <div class="city-item" id="taclobanBtn">Tacloban</div>
                <div class="city-item" id="tawiTawiBtn">Tawi-Tawi</div>
                <div class="city-item" id="tuguegaraoBtn">Tuguegarao</div>
                <div class="city-item" id="viracBtn">Virac</div>
                <div class="city-item" id="zamboangaBtn">Zamboanga</div>
              </div>
              <div>
                <div class="country-item" id="saudiArabiaBtn">Saudi Arabia</div>
                <div class="city-item" id="riyadhBtn">Riyadh</div>
              </div>
              <div>
                <div class="country-item" id="singaporeBtn">Singapore</div>
                <div class="city-item" id="singaporeCityBtn">Singapore</div>
              </div>
              <div>
                <div class="country-item" id="southKoreaBtn">South Korea</div>
                <div class="city-item" id="seoulBtn">Seoul (Incheon)</div>
              </div>
              <div>
                <div class="country-item" id="taiwanBtn">Taiwan (China)</div>
                <div class="city-item" id="kaohsiungBtn">Kaohsiung</div>
                <div class="city-item" id="taipeiBtn">Taipei</div>
              </div>
              <div>
                <div class="country-item" id="thailandBtn">Thailand</div>
                <div class="city-item" id="bangkokDonMueangBtn">Bangkok (Don Mueang)</div>
                <div class="city-item" id="bangkokSuvarnabhumiBtn">Bangkok (Suvarnabhumi)</div>
                <div class="city-item" id="chiangMaiBtn">Chiang Mai</div>
              </div>
              <div>
                <div class="country-item" id="uaeBtn">United Arab Emirates</div>
                <div class="city-item" id="dubaiBtn">Dubai</div>
              </div>
              <div>
                <div class="country-item" id="vietnamBtn">Vietnam</div>
                <div class="city-item" id="daNangBtn">Da Nang</div>
                <div class="city-item" id="hanoiBtn">Hanoi</div>
                <div class="city-item" id="hoChiMinhBtn">Ho Chi Minh (Saigon)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group" style="position: relative;">
        <label>To</label>
        <div class="input-box" id="destination-box" style="position: relative;">
          <div class="swap-icon" id="swapBtn">⇄</div>
          <input type="text" id="destination-input" placeholder="Select Destination" readonly>
          <span class="icon-right">▼</span>
        </div>
        <!-- Location Dropdown Modal for Destination -->
        <div class="location-modal" id="destinationLocationModal">
          <div class="modal-left">
            <div class="modal-left-item">
              <span>✈</span> All Locations <span class="arrow">&gt;</span>
            </div>
          </div>
          <div class="modal-right">
            <h4>Country</h4>
            <div class="country-grid">
              <div class="dest-country-wrapper" data-country="Australia">
                <div class="country-item" id="dest-australiaBtn">Australia</div>
                <div class="city-item dest-city-item" id="dest-melbourneBtn" data-city-name="Melbourne">Melbourne</div>
                <div class="city-item dest-city-item" id="dest-sydneyBtn" data-city-name="Sydney">Sydney</div>
              </div>
              <div class="dest-country-wrapper" data-country="China">
                <div class="country-item" id="dest-chinaBtn">China</div>
                <div class="city-item dest-city-item" id="dest-guangzhouBtn" data-city-name="Guangzhou (Canton)">Guangzhou (Canton)</div>
                <div class="city-item dest-city-item" id="dest-shanghaiBtn" data-city-name="Shanghai">Shanghai</div>
                <div class="city-item dest-city-item" id="dest-shenzhenBtn" data-city-name="Shenzhen">Shenzhen</div>
                <div class="city-item dest-city-item" id="dest-xiamenBtn" data-city-name="Xiamen">Xiamen</div>
              </div>
              <div class="dest-country-wrapper" data-country="Brunei Darussalam">
                <div class="country-item" id="dest-bruneiBtn">Brunei Darussalam</div>
                <div class="city-item dest-city-item" id="dest-bandarBtn" data-city-name="Bandar Seri Begawan (Brunei)">Bandar Seri Begawan (Brunei)</div>
              </div>
              <div class="dest-country-wrapper" data-country="Hong Kong (China)">
                <div class="country-item" id="dest-hongKongBtn">Hong Kong (China)</div>
                <div class="city-item dest-city-item" id="dest-hongKongCityBtn" data-city-name="HongKong">HongKong</div>
              </div>
              <div class="dest-country-wrapper" data-country="Indonesia">
                <div class="country-item" id="dest-indonesiaBtn">Indonesia</div>
                <div class="city-item dest-city-item" id="dest-baliBtn" data-city-name="Bali (Denpasar)">Bali (Denpasar)</div>
                <div class="city-item dest-city-item" id="dest-jakartaBtn" data-city-name="Jakarta">Jakarta</div>
              </div>
              <div class="dest-country-wrapper" data-country="Japan">
                <div class="country-item" id="dest-japanBtn">Japan</div>
                <div class="city-item dest-city-item" id="dest-fukuokaBtn" data-city-name="Fukuoka">Fukuoka</div>
                <div class="city-item dest-city-item" id="dest-nagoyaBtn" data-city-name="Nagoya">Nagoya</div>
                <div class="city-item dest-city-item" id="dest-osakaBtn" data-city-name="Osaka (Kansai)">Osaka (Kansai)</div>
                <div class="city-item dest-city-item" id="dest-sapporoBtn" data-city-name="Sapporo (New Chitose)">Sapporo (New Chitose)</div>
              </div>
              <div class="dest-country-wrapper" data-country="Macau (China)">
                <div class="country-item" id="dest-macauBtn">Macau (China)</div>
                <div class="city-item dest-city-item" id="dest-macauCityBtn" data-city-name="Macau">Macau</div>
              </div>
              <div class="dest-country-wrapper" data-country="Malaysia">
                <div class="country-item" id="dest-malaysiaBtn">Malaysia</div>
                <div class="city-item dest-city-item" id="dest-kualaLumpurBtn" data-city-name="Kuala Lumpur">Kuala Lumpur</div>
              </div>
              <div class="dest-country-wrapper" data-country="Philippines">
                <div class="country-item" id="dest-philippinesBtn">Philippines</div>
                <div class="city-item dest-city-item" id="dest-bacolodBtn" data-city-name="Bacolod">Bacolod</div>
                <div class="city-item dest-city-item" id="dest-boholBtn" data-city-name="Bohol">Bohol</div>
                <div class="city-item dest-city-item" id="dest-boracayBtn" data-city-name="Boracay (Caticlan)">Boracay (Caticlan)</div>
                <div class="city-item dest-city-item" id="dest-butuanBtn" data-city-name="Butuan">Butuan</div>
                <div class="city-item dest-city-item" id="dest-cagayanBtn" data-city-name="Cagayan de Oro">Cagayan de Oro</div>
                <div class="city-item dest-city-item" id="dest-calbayogBtn" data-city-name="Calbayog">Calbayog</div>
                <div class="city-item dest-city-item" id="dest-camiguinBtn" data-city-name="Camiguin">Camiguin</div>
                <div class="city-item dest-city-item" id="dest-cauayanBtn" data-city-name="Cauayan">Cauayan</div>
                <div class="city-item dest-city-item" id="dest-cebuBtn" data-city-name="Cebu">Cebu</div>
                <div class="city-item dest-city-item" id="dest-clarkBtn" data-city-name="Clark">Clark</div>
                <div class="city-item dest-city-item" id="dest-coronBtn" data-city-name="Coron (Busuanga)">Coron (Busuanga)</div>
                <div class="city-item dest-city-item" id="dest-cotabatoBtn" data-city-name="Cotabato">Cotabato</div>
                <div class="city-item dest-city-item" id="dest-davaoBtn" data-city-name="Davao">Davao</div>
                <div class="city-item dest-city-item" id="dest-dipologBtn" data-city-name="Dipolog">Dipolog</div>
                <div class="city-item dest-city-item" id="dest-dumagueteBtn" data-city-name="Dumaguete">Dumaguete</div>
                <div class="city-item dest-city-item" id="dest-elNidoBtn" data-city-name="El Nido">El Nido</div>
                <div class="city-item dest-city-item" id="dest-generalSantosBtn" data-city-name="General Santos">General Santos</div>
                <div class="city-item dest-city-item" id="dest-iloiloBtn" data-city-name="Iloilo">Iloilo</div>
                <div class="city-item dest-city-item" id="dest-kaliboBtn" data-city-name="Kalibo">Kalibo</div>
                <div class="city-item dest-city-item" id="dest-laoagBtn" data-city-name="Laoag">Laoag</div>
                <div class="city-item dest-city-item" id="dest-legazpiBtn" data-city-name="Legazpi (Daraga)">Legazpi (Daraga)</div>
                <div class="city-item dest-city-item" id="dest-manilaBtn" data-city-name="Manila">Manila</div>
                <div class="city-item dest-city-item" id="dest-masbateBtn" data-city-name="Masbate">Masbate</div>
                <div class="city-item dest-city-item" id="dest-nagaBtn" data-city-name="Naga">Naga</div>
                <div class="city-item dest-city-item" id="dest-ozamizBtn" data-city-name="Ozamiz">Ozamiz</div>
                <div class="city-item dest-city-item" id="dest-pagadianBtn" data-city-name="Pagadian">Pagadian</div>
                <div class="city-item dest-city-item" id="dest-puertoPrincesaBtn" data-city-name="Puerto Princesa">Puerto Princesa</div>
                <div class="city-item dest-city-item" id="dest-roxasBtn" data-city-name="Roxas">Roxas</div>
                <div class="city-item dest-city-item" id="dest-sanJoseBtn" data-city-name="San Jose (Mindoro)">San Jose (Mindoro)</div>
                <div class="city-item dest-city-item" id="dest-sanVicenteBtn" data-city-name="San Vicente (Port Barton)">San Vicente (Port Barton)</div>
                <div class="city-item dest-city-item" id="dest-siargaoBtn" data-city-name="Siargao">Siargao</div>
                <div class="city-item dest-city-item" id="dest-surigaoBtn" data-city-name="Surigao">Surigao</div>
                <div class="city-item dest-city-item" id="dest-taclobanBtn" data-city-name="Tacloban">Tacloban</div>
                <div class="city-item dest-city-item" id="dest-tawiTawiBtn" data-city-name="Tawi-Tawi">Tawi-Tawi</div>
                <div class="city-item dest-city-item" id="dest-tuguegaraoBtn" data-city-name="Tuguegarao">Tuguegarao</div>
                <div class="city-item dest-city-item" id="dest-viracBtn" data-city-name="Virac">Virac</div>
                <div class="city-item dest-city-item" id="dest-zamboangaBtn" data-city-name="Zamboanga">Zamboanga</div>
              </div>
              <div class="dest-country-wrapper" data-country="Saudi Arabia">
                <div class="country-item" id="dest-saudiArabiaBtn">Saudi Arabia</div>
                <div class="city-item dest-city-item" id="dest-riyadhBtn" data-city-name="Riyadh">Riyadh</div>
              </div>
              <div class="dest-country-wrapper" data-country="Singapore">
                <div class="country-item" id="dest-singaporeBtn">Singapore</div>
                <div class="city-item dest-city-item" id="dest-singaporeCityBtn" data-city-name="Singapore">Singapore</div>
              </div>
              <div class="dest-country-wrapper" data-country="South Korea">
                <div class="country-item" id="dest-southKoreaBtn">South Korea</div>
                <div class="city-item dest-city-item" id="dest-seoulBtn" data-city-name="Seoul (Incheon)">Seoul (Incheon)</div>
              </div>
              <div class="dest-country-wrapper" data-country="Taiwan (China)">
                <div class="country-item" id="dest-taiwanBtn">Taiwan (China)</div>
                <div class="city-item dest-city-item" id="dest-kaohsiungBtn" data-city-name="Kaohsiung">Kaohsiung</div>
                <div class="city-item dest-city-item" id="dest-taipeiBtn" data-city-name="Taipei">Taipei</div>
              </div>
              <div class="dest-country-wrapper" data-country="Thailand">
                <div class="country-item" id="dest-thailandBtn">Thailand</div>
                <div class="city-item dest-city-item" id="dest-bangkokDonMueangBtn" data-city-name="Bangkok (Don Mueang)">Bangkok (Don Mueang)</div>
                <div class="city-item dest-city-item" id="dest-bangkokSuvarnabhumiBtn" data-city-name="Bangkok (Suvarnabhumi)">Bangkok (Suvarnabhumi)</div>
                <div class="city-item dest-city-item" id="dest-chiangMaiBtn" data-city-name="Chiang Mai">Chiang Mai</div>
              </div>
              <div class="dest-country-wrapper" data-country="United Arab Emirates">
                <div class="country-item" id="dest-uaeBtn">United Arab Emirates</div>
                <div class="city-item dest-city-item" id="dest-dubaiBtn" data-city-name="Dubai">Dubai</div>
              </div>
              <div class="dest-country-wrapper" data-country="Vietnam">
                <div class="country-item" id="dest-vietnamBtn">Vietnam</div>
                <div class="city-item dest-city-item" id="dest-daNangBtn" data-city-name="Da Nang">Da Nang</div>
                <div class="city-item dest-city-item" id="dest-hanoiBtn" data-city-name="Hanoi">Hanoi</div>
                <div class="city-item dest-city-item" id="dest-hoChiMinhBtn" data-city-name="Ho Chi Minh (Saigon)">Ho Chi Minh (Saigon)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group" style="position: relative;">
        <label>Depart</label>
        <div class="input-box" id="depart-box">
          <input type="text" id="depart-input" value="24 Jul 2026" readonly>
          <span class="icon-right">📅</span>
        </div>
        <!-- Calendar Popup Modal -->
        <div class="calendar-modal" id="calendarModal">
          <div class="calendar-container">
            <!-- Left Month -->
            <div class="calendar-month">
              <div class="calendar-header">
                <button type="button" id="prevMonthBtn">&lt;</button>
                <span id="month1Label">July 2026</span>
                <span></span>
              </div>
              <div class="calendar-weekdays">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
              </div>
              <div class="calendar-grid" id="month1Grid"></div>
            </div>
            <!-- Right Month -->
            <div class="calendar-month">
              <div class="calendar-header">
                <span></span>
                <span id="month2Label">August 2026</span>
                <button type="button" id="nextMonthBtn">&gt;</button>
              </div>
              <div class="calendar-weekdays">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
              </div>
              <div class="calendar-grid" id="month2Grid"></div>
            </div>
          </div>
          <div class="calendar-footer">
            <button type="button" class="select-dates-btn" id="selectDatesBtn">Select dates</button>
          </div>
        </div>
      </div>
      <div class="form-group" style="position: relative;">
        <label>Return</label>
        <div class="input-box" id="return-box">
          <input type="text" id="return-input" placeholder="Returning on" readonly>
          <span class="icon-right">📅</span>
        </div>
      </div>
    </div>
    <!-- Second Row of Inputs -->
    <div class="form-grid select-grid">
      <div class="form-group">
        <label>Adults</label>
        <div class="input-box">
          <select id="adults-select">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
          </select>
        </div>
        <div class="sub-label">12+ years</div>
      </div>
      <div class="form-group">
        <label>Children</label>
        <div class="input-box">
          <select id="children-select">
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
          </select>
        </div>
        <div class="sub-label">2-11 years</div>
      </div>
      <div class="form-group">
        <label>Infant</label>
        <div class="input-box">
          <select>
            <option>0</option>
            <option>1</option>
            <option>2</option>
          </select>
        </div>
        <div class="sub-label">under 2 years</div>
      </div>
    </div>
    <!-- Search Button -->
    <div class="button-container">
      <button class="search-btn" id="searchFlightsBtn">Search flights</button>
    </div>
  </div>
</div>

<!-- VIEW 2: SELECT FLIGHT -->
<div id="selectView" class="view-section">
  <!-- Top Flight Summary Strip (Includes Back Button) -->
  <div class="flight-summary-strip">
    <div class="flight-summary-content">
      <div class="summary-left">
        <button class="back-link-btn" id="backToSearchBtn">
          &#10094; Back
        </button>
        <span style="color: #4a6fa5;">|</span>
        <span class="summary-route" id="summaryRouteText">Manila to Cebu</span>
        <div class="summary-details">
          <span id="summaryDatesText">Fri, 24 Jul 2026</span>
          <span>•</span>
          <span id="summaryGuestsText">1 Guest</span>
        </div>
      </div>
      <button class="modify-search-btn" id="modifySearchBtn">Modify Search</button>
    </div>
  </div>
  <!-- HEADER STEPPER (inserted from guestinfos.html, replaces old Progress Steps Header) -->
  <div class="gh-header">
    <div class="gh-stepper">
      <div class="gh-step gh-active">
        <div class="gh-circle-badge"><div class="gh-circle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </div></div>
        <label>Select Flight</label>
      </div>
      <div class="gh-step">
        <div class="gh-connector"></div>
        <div class="gh-circle-badge"><div class="gh-circle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M7 20c0-3 2-5 5-5s5 2 5 5"/></svg>
        </div></div>
        <label>Guest Details</label>
      </div>
      <div class="gh-step">
        <div class="gh-connector"></div>
        <div class="gh-circle-badge"><div class="gh-circle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div></div>
        <label>Add-ons</label>
      </div>
      <div class="gh-step">
        <div class="gh-connector"></div>
        <div class="gh-circle-badge"><div class="gh-circle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
        </div></div>
        <label>Payment</label>
      </div>
      <div class="gh-step">
        <div class="gh-connector"></div>
        <div class="gh-circle-badge"><div class="gh-circle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div></div>
        <label>Confirmation</label>
      </div>
    </div>
  </div>
  <div class="page">
    <div class="section-label">Departing Flight</div>
    <div class="route-title">
      <span id="routeCities">Manila to Cebu</span>
      <span class="plane">&#9992;</span>
    </div>
    <!-- Date Strip -->
    <div class="date-strip">
      <button class="date-nav-btn" id="prevDateStripBtn">&#10094;</button>
      <div class="date-cells" id="dateCellsContainer">
        <!-- Dynamic Date Cells Will Be Rendered Here -->
      </div>
      <button class="date-nav-btn" id="nextDateStripBtn">&#10095;</button>
    </div>
    <!-- Filter and Sort Bar -->
    <div class="filter-row">
      <div class="filter-dropdown-wrapper">
        <button class="filter-btn" id="timeFilterBtn">
          Time of flight <span class="arrow">&#9660;</span>
        </button>
        <div class="time-filter-menu" id="timeFilterMenu">
          <div class="time-filter-tabs">
            <button class="time-tab active" id="departureTab" data-mode="departure" type="button">&#9992;&#65039; Departure</button>
            <button class="time-tab" id="arrivalTab" data-mode="arrival" type="button">&#128747; Arrival</button>
          </div>
          <div class="time-filter-options">
            <label class="time-filter-option">
              <input type="checkbox" class="time-checkbox" value="0-360"> 12:00 am - 06:00 am
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="time-checkbox" value="361-720"> 06:01 am - 12:00 pm
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="time-checkbox" value="721-1080"> 12:01 pm - 06:00 pm
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="time-checkbox" value="1081-1439"> 06:01 pm - 11:59 pm
            </label>
          </div>
          <div class="time-filter-actions">
            <button class="filter-reset-btn" id="timeFilterReset" type="button">Reset</button>
            <button class="filter-apply-btn" id="timeFilterApply" type="button">Apply</button>
          </div>
        </div>
      </div>
      <div class="filter-dropdown-wrapper">
        <button class="filter-btn" id="stopsFilterBtn">
          Stops <span class="arrow">&#9660;</span>
        </button>
        <div class="stops-filter-menu" id="stopsFilterMenu">
          <div class="time-filter-options">
            <label class="time-filter-option">
              <input type="checkbox" class="stops-checkbox" value="Direct"> Direct
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="stops-checkbox" value="1 Stop"> 1 Stop
            </label>
          </div>
          <div class="time-filter-actions">
            <button class="filter-reset-btn" id="stopsFilterReset" type="button">Reset</button>
            <button class="filter-apply-btn" id="stopsFilterApply" type="button">Apply</button>
          </div>
        </div>
      </div>
      <div class="sort-dropdown-wrapper">
        <button class="filter-btn sort-btn" id="sortBtn">
          Sort by <span class="arrow">&#9660;</span>
        </button>
        <div class="sort-menu" id="sortMenu">
          <div class="sort-option" data-sort="price">Price (Lowest first)</div>
          <div class="sort-option" data-sort="depart">Departure time</div>
          <div class="sort-option" data-sort="duration">Duration</div>
        </div>
      </div>
    </div>
    <!-- No Flights Message Container -->
    <div id="noFlightsMsg" class="no-flights-msg">
      <div class="no-flights-icon">
        <svg viewBox="0 0 200 160" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="100" cy="130" rx="95" ry="14" fill="#eaf4fb"/>
          <circle cx="55" cy="55" r="30" fill="#dff0fb"/>
          <circle cx="120" cy="40" r="20" fill="#dff0fb"/>
          <circle cx="145" cy="70" r="26" fill="#dff0fb"/>
          <g transform="translate(45,50) rotate(-18)">
            <path d="M0 40 L90 40 L110 30 L100 40 L110 50 L90 40 Z" fill="#bcdff2"/>
            <path d="M10 40 L70 15 L78 18 L45 40 Z" fill="#5aa9d6"/>
            <path d="M10 40 L70 65 L78 62 L45 40 Z" fill="#5aa9d6"/>
            <path d="M0 40 L100 40 L112 40 L100 40 Z" fill="#3a7ca8"/>
            <ellipse cx="20" cy="40" rx="20" ry="8" fill="#f5c518"/>
            <circle cx="30" cy="37" r="2.4" fill="#3a7ca8"/>
            <circle cx="38" cy="37" r="2.4" fill="#3a7ca8"/>
            <circle cx="46" cy="37" r="2.4" fill="#3a7ca8"/>
          </g>
        </svg>
      </div>
      <div class="no-flights-text">
        <div class="no-flights-title">No flights available</div>
        <div class="no-flights-desc">Flights for this day are either sold out or unavailable. Please choose another date or try editing your search details.</div>
      </div>
    </div>
    <!-- Flight Cards Container -->
    <div id="flightsContainer">
      <!-- Flight Card 1 -->
      <div class="flight-card" data-price="3120" data-depart="04:15" data-duration="85" data-date="2026-07-24">
        <div class="flight-left">
          <div class="flight-times">
            <div class="time-group">
              <span class="time">04:15</span><span class="period">AM</span>
              <span class="city">MNL</span>
            </div>
            <span class="arrow-sep">&#10140;</span>
            <div class="time-group">
              <span class="time">05:40</span><span class="period">AM</span>
              <span class="city">CEB</span>
            </div>
          </div>
          <div class="flight-meta">
            <span class="flight-num">DG 6177</span>
            <span class="direct-badge">Direct</span>
            <span class="duration">1h 25m</span>
          </div>
        </div>
        <div class="flight-right">
          <span class="price-label">Starts from</span>
          <div class="price-amount"><span class="currency">PHP</span>3,120.00</div>
          <button class="select-btn">Select</button>
        </div>
      </div>
      <!-- Flight Card 2 -->
      <div class="flight-card" data-price="3450" data-depart="08:30" data-duration="90" data-date="2026-07-24">
        <div class="flight-left">
          <div class="flight-times">
            <div class="time-group">
              <span class="time">08:30</span><span class="period">AM</span>
              <span class="city">MNL</span>
            </div>
            <span class="arrow-sep">&#10140;</span>
            <div class="time-group">
              <span class="time">10:00</span><span class="period">AM</span>
              <span class="city">CEB</span>
            </div>
          </div>
          <div class="flight-meta">
            <span class="flight-num">5J 563</span>
            <span class="direct-badge">Direct</span>
            <span class="duration">1h 30m</span>
          </div>
        </div>
        <div class="flight-right">
          <span class="price-label">Starts from</span>
          <div class="price-amount"><span class="currency">PHP</span>3,450.00</div>
          <button class="select-btn">Select</button>
        </div>
      </div>
      <!-- Flight Card 3 -->
      <div class="flight-card" data-price="2980" data-depart="13:10" data-duration="85" data-date="2026-07-24">
        <div class="flight-left">
          <div class="flight-times">
            <div class="time-group">
              <span class="time">13:10</span><span class="period">PM</span>
              <span class="city">MNL</span>
            </div>
            <span class="arrow-sep">&#10140;</span>
            <div class="time-group">
              <span class="time">14:35</span><span class="period">PM</span>
              <span class="city">CEB</span>
            </div>
          </div>
          <div class="flight-meta">
            <span class="flight-num">5J 575</span>
            <span class="direct-badge">Direct</span>
            <span class="duration">1h 25m</span>
          </div>
        </div>
        <div class="flight-right">
          <span class="price-label">Starts from</span>
          <div class="price-amount"><span class="currency">PHP</span>2,980.00</div>
          <button class="select-btn">Select</button>
        </div>
      </div>
      <!-- Flight Card 4 -->
      <div class="flight-card" data-price="4100" data-depart="17:45" data-duration="95" data-date="2026-07-24">
        <div class="flight-left">
          <div class="flight-times">
            <div class="time-group">
              <span class="time">17:45</span><span class="period">PM</span>
              <span class="city">MNL</span>
            </div>
            <span class="arrow-sep">&#10140;</span>
            <div class="time-group">
              <span class="time">19:20</span><span class="period">PM</span>
              <span class="city">CEB</span>
            </div>
          </div>
          <div class="flight-meta">
            <span class="flight-num">DG 6181</span>
            <span class="direct-badge">Direct</span>
            <span class="duration">1h 35m</span>
          </div>
        </div>
        <div class="flight-right">
          <span class="price-label">Starts from</span>
          <div class="price-amount"><span class="currency">PHP</span>4,100.00</div>
          <button class="select-btn">Select</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Returning Flight Page (inserted; shown only for round-trip with a return date) -->
  <div class="page" id="returnFlightPage" style="display:none;">
    <div class="section-label">Returning Flight</div>
    <div class="route-title">
      <span id="retRouteCities">Cebu to Manila</span>
      <span class="plane">&#9992;</span>
    </div>
    <!-- Return Date Strip -->
    <div class="date-strip">
      <button class="date-nav-btn" id="retPrevDateStripBtn">&#10094;</button>
      <div class="date-cells" id="retDateCellsContainer">
        <!-- Dynamic Date Cells Will Be Rendered Here -->
      </div>
      <button class="date-nav-btn" id="retNextDateStripBtn">&#10095;</button>
    </div>
    <!-- Return Filter and Sort Bar -->
    <div class="filter-row">
      <div class="filter-dropdown-wrapper">
        <button class="filter-btn" id="retTimeFilterBtn">
          Time of flight <span class="arrow">&#9660;</span>
        </button>
        <div class="time-filter-menu" id="retTimeFilterMenu">
          <div class="time-filter-tabs">
            <button class="time-tab active" id="retDepartureTab" data-mode="departure" type="button">&#9992;&#65039; Departure</button>
            <button class="time-tab" id="retArrivalTab" data-mode="arrival" type="button">&#128747; Arrival</button>
          </div>
          <div class="time-filter-options">
            <label class="time-filter-option">
              <input type="checkbox" class="ret-time-checkbox" value="0-360"> 12:00 am - 06:00 am
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="ret-time-checkbox" value="361-720"> 06:01 am - 12:00 pm
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="ret-time-checkbox" value="721-1080"> 12:01 pm - 06:00 pm
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="ret-time-checkbox" value="1081-1439"> 06:01 pm - 11:59 pm
            </label>
          </div>
          <div class="time-filter-actions">
            <button class="filter-reset-btn" id="retTimeFilterReset" type="button">Reset</button>
            <button class="filter-apply-btn" id="retTimeFilterApply" type="button">Apply</button>
          </div>
        </div>
      </div>
      <div class="filter-dropdown-wrapper">
        <button class="filter-btn" id="retStopsFilterBtn">
          Stops <span class="arrow">&#9660;</span>
        </button>
        <div class="stops-filter-menu" id="retStopsFilterMenu">
          <div class="time-filter-options">
            <label class="time-filter-option">
              <input type="checkbox" class="ret-stops-checkbox" value="Direct"> Direct
            </label>
            <label class="time-filter-option">
              <input type="checkbox" class="ret-stops-checkbox" value="1 Stop"> 1 Stop
            </label>
          </div>
          <div class="time-filter-actions">
            <button class="filter-reset-btn" id="retStopsFilterReset" type="button">Reset</button>
            <button class="filter-apply-btn" id="retStopsFilterApply" type="button">Apply</button>
          </div>
        </div>
      </div>
      <div class="sort-dropdown-wrapper">
        <button class="filter-btn sort-btn" id="retSortBtn">
          Sort by <span class="arrow">&#9660;</span>
        </button>
        <div class="sort-menu" id="retSortMenu">
          <div class="sort-option" data-sort="price">Price (Lowest first)</div>
          <div class="sort-option" data-sort="depart">Departure time</div>
          <div class="sort-option" data-sort="duration">Duration</div>
        </div>
      </div>
    </div>
    <!-- Return No Flights Message Container -->
    <div id="retNoFlightsMsg" class="no-flights-msg">
      <div class="no-flights-icon">
        <svg viewBox="0 0 200 160" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="100" cy="130" rx="95" ry="14" fill="#eaf4fb"/>
          <circle cx="55" cy="55" r="30" fill="#dff0fb"/>
          <circle cx="120" cy="40" r="20" fill="#dff0fb"/>
          <circle cx="145" cy="70" r="26" fill="#dff0fb"/>
          <g transform="translate(45,50) rotate(-18)">
            <path d="M0 40 L90 40 L110 30 L100 40 L110 50 L90 40 Z" fill="#bcdff2"/>
            <path d="M10 40 L70 15 L78 18 L45 40 Z" fill="#5aa9d6"/>
            <path d="M10 40 L70 65 L78 62 L45 40 Z" fill="#5aa9d6"/>
            <path d="M0 40 L100 40 L112 40 L100 40 Z" fill="#3a7ca8"/>
            <ellipse cx="20" cy="40" rx="20" ry="8" fill="#f5c518"/>
            <circle cx="30" cy="37" r="2.4" fill="#3a7ca8"/>
            <circle cx="38" cy="37" r="2.4" fill="#3a7ca8"/>
            <circle cx="46" cy="37" r="2.4" fill="#3a7ca8"/>
          </g>
        </svg>
      </div>
      <div class="no-flights-text">
        <div class="no-flights-title">No flights available</div>
        <div class="no-flights-desc">Flights for this day are either sold out or unavailable. Please choose another date or try editing your search details.</div>
      </div>
    </div>
    <!-- Return Flight Cards Container (populated dynamically) -->
    <div id="retFlightsContainer"></div>
  </div>
  <!-- Continue Bar (inserted) -->
  <div class="continue-bar">
    <span class="continue-hint" id="continueHint">Select a flight to continue</span>
    <button class="continue-btn" id="continueBtn" disabled>Continue</button>
  </div>
</div>

<!-- Script Container -->
<!-- ===== Guest Details view (merged from guestinfos.html) ===== -->
<div id="guestView" class="view-section">

<!-- HEADER STEPPER -->
<div class="gi-header">
  <div class="stepper">
    <div class="gi-step done">
      <div class="circle-badge"><div class="circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      </div></div>
      <label>Select Flight</label>
    </div>
    <div class="gi-step active">
      <div class="connector"></div>
      <div class="circle-badge"><div class="circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M7 20c0-3 2-5 5-5s5 2 5 5"/></svg>
      </div></div>
      <label>Guest Details</label>
    </div>
    <div class="gi-step">
      <div class="connector"></div>
      <div class="circle-badge"><div class="circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      </div></div>
      <label>Add-ons</label>
    </div>
    <div class="gi-step">
      <div class="connector"></div>
      <div class="circle-badge"><div class="circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
      </div></div>
      <label>Payment</label>
    </div>
    <div class="gi-step">
      <div class="connector"></div>
      <div class="circle-badge"><div class="circle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div></div>
      <label>Confirmation</label>
    </div>
  </div>
</div>

<p class="page-intro">Now that you've selected your flight, enter your details.</p>
<h1 class="page-title">Guest Details</h1>

<div class="content-wrap">
  <div class="guest-tabs">
    <div class="guest-tab">
      <span class="num">Adult 1</span>
      <span class="name" id="tabName">Guest</span>
    </div>
  </div>

  <div class="form-card">
    <span class="bundle-label">SELECTED BUNDLES FOR THIS GUEST</span>
    <div class="bundle-route">Manila (MNL) &#9992; Masbate (MBT)</div>
    <div class="bundle-fare">GO Basic &#9992;</div>
    <hr class="sep">

    <span class="field-label">Name</span>
    <p class="helper-text">Please make sure that you enter your name exactly as it is shown on your Valid ID.</p>

    <div class="row">
      <div style="max-width:110px;">
        <label class="field-label">Title<span class="req">*</span></label>
        <select id="title">
          <option value="" selected disabled>Select</option>
          <option>Mr.</option>
          <option>Ms.</option>
          <option>Mrs.</option>
        </select>
      </div>
      <div>
        <label class="field-label">First name<span class="req">*</span></label>
        <input type="text" id="firstName" placeholder="e.g. Andrew" oninput="syncName()">
      </div>
      <div>
        <label class="field-label">Last name<span class="req">*</span></label>
        <input type="text" id="lastName" placeholder="e.g. Cruz" oninput="syncName()">
      </div>
    </div>

    <label class="no-first-name">
      <input type="checkbox" id="noFirstName" onchange="toggleFirstName()">
      I have no first name <i class="info-icon">i</i>
    </label>

    <hr class="sep">

    <span class="field-label">Date of Birth</span>
    <div class="row" style="margin-top:8px;">
      <div style="max-width:90px;">
        <label class="field-label">Day<span class="req">*</span></label>
        <div class="dropdown" id="dayDropdown">
          <input type="text" class="dropdown-input" id="dayInput" placeholder="DD" readonly>
          <div class="dropdown-list" id="dayList"></div>
        </div>
      </div>
      <div style="max-width:140px;">
        <label class="field-label">Month<span class="req">*</span></label>
        <div class="dropdown" id="monthDropdown">
          <input type="text" class="dropdown-input" id="monthInput" placeholder="Month" readonly>
          <div class="dropdown-list" id="monthList"></div>
        </div>
      </div>
      <div style="max-width:110px;">
        <label class="field-label">Year<span class="req">*</span></label>
        <div class="dropdown" id="yearDropdown">
          <input type="text" class="dropdown-input" id="yearInput" placeholder="YYYY" readonly>
          <div class="dropdown-list" id="yearList"></div>
        </div>
      </div>
    </div>

    <div id="nationalityField" style="margin-bottom:18px;">
    <label class="field-label">Nationality<span class="req">*</span></label>
    <select id="nationalitySelect">
<option value="" selected disabled>Select nationality</option>
<option>Philippines, Republic of the</option>
<option>Afghanistan</option>
<option>Aland Islands</option>
<option>Albania, People's Socialist Republic of</option>
<option>Algeria, People's Democratic Republic of</option>
<option>American Samoa</option>
<option>Andorra, Principality of</option>
<option>Angola, Republic of</option>
<option>Anguilla</option>
<option>Antigua and Barbuda</option>
<option>Argentina, Argentine Republic</option>
<option>Armenia</option>
<option>Aruba</option>
<option>Australia</option>
<option>Austria, Republic of</option>
<option>Azerbaijan, Rpublic of</option>
<option>Bahamas, Commonwealth of the</option>
<option>Bahrain, Kingdom of</option>
<option>Bangladesh, People's Republic of</option>
<option>Barbados</option>
<option>Belarus</option>
<option>Belgium, Kingdom of</option>
<option>Belize</option>
<option>Benin (Was Dahomey), People's Republic of</option>
<option>Bermuda</option>
<option>Bhutan, Kingdom of</option>
<option>Bolivia, Republic of</option>
<option>Bosnia and Herzegovina</option>
<option>Botswana, Republic of</option>
<option>Brazil, Federative Republic of</option>
<option>British Virgin Islands</option>
<option>Brunei, Darussalam</option>
<option>Bulgaria, Republic of</option>
<option>Burkini Faso(was Upper Volta)</option>
<option>Burundi, Republic of</option>
<option>Cambodia</option>
<option>Cameroon, United Republic of</option>
<option>Canada</option>
<option>Cape Verde, Republic of</option>
<option>Cayman Islands</option>
<option>Central African Republic</option>
<option>Chad, Republic of</option>
<option>Chile, Republic of</option>
<option>China</option>
<option>Christmas Islands</option>
<option>Cocos(Keeling) Islands</option>
<option>Colombia, Republic of</option>
<option>Comoros, Union of the </option>
<option>Congo, Democratic Republic of(was Zaire)</option>
<option>Cook Islands</option>
<option>Costa Rica, Republic of</option>
<option>Croatia</option>
<option>Cuba, Republic of</option>
<option>Curacao, </option>
<option>Cyprus, Republic of</option>
<option>Czech Republic</option>
<option>Denmark, Kingdom of</option>
<option>Djibouti, Republic of(French Afas and Isaac)</option>
<option>Dominica, Commonwealth of</option>
<option>Dominican Republic</option>
<option>Ecuador, Republic of</option>
<option>Egypt, Arab Republic of</option>
<option>El Salvador, Republic of</option>
<option>Equatorial Guinea, Republic of</option>
<option>Eritrea</option>
<option>Estonia</option>
<option>Eswatini</option>
<option>Ethiopia</option>
<option>Faeroe Islands</option>
<option>Falkland Islands (Malvinas)</option>
<option>Fiji, Republic of the Fiji Islands</option>
<option>Finland, Republic of</option>
<option>France, French Republic</option>
<option>French Guiana</option>
<option>French Polynesia</option>
<option>French Southern Territories</option>
<option>Gabon, Gabonese Republic</option>
<option>Gambia, Republic of the</option>
<option>Georgia</option>
<option>Germany</option>
<option>Ghana, Rpublic of</option>
<option>Gilbratar</option>
<option>Greece, Hellenic Republic</option>
<option>Greenlanda</option>
<option>Grenada</option>
<option>Guadoloupe</option>
<option>Guam</option>
<option>Guatamela, Republic of</option>
<option>Guernsey</option>
<option>Guinea-Bissau, Republic of (was Portugese Guinea)</option>
<option>Guinea, Revolutionary People's Rep'c of</option>
<option>Guyana, Republic of</option>
<option>Haiti, Republic of</option>
<option>Heard and McDonald Islands</option>
<option>Holy See(Vatican City State)</option>
<option>Honduras, Republic of</option>
<option>Hong Kong(China)</option>
<option>Hungary</option>
<option>Iceland, Republic of</option>
<option>India, Republic of</option>
<option>Indonesia</option>
<option>Iran, Islamic Republic of</option>
<option>Iraq, Republic of</option>
<option>Ireland</option>
<option>Isle of Man</option>
<option>Israel, State of</option>
<option>Italy, Italian Republic</option>
<option>Ivory Coast(was Cote D'Ivore), Republic of the</option>
<option>Jamaica</option>
<option>Japan</option>
<option>Jersey</option>
<option>Jordan, Hashemite Kingdom of</option>
<option>Kazakhstan, Republic of</option>
<option>Kenya, Republic of</option>
<option>Kiribati, Republic of (was Gilbert Islands)</option>
<option>Korea, Democratic People's Republic of</option>
<option>Korea</option>
<option>Kuwait</option>
<option>Kyrgyz Republic</option>
<option>Laos, People's Democratic Repbublic of</option>
<option>Latvia</option>
<option>Lebanon, Lebanese Republic</option>
<option>Lesotho, Kingdom of</option>
<option>Liberia, Republic of</option>
<option>Libya</option>
<option>Liechtenstein, Principality of</option>
<option>Lithuania</option>
<option>Luxembourg, Grand Duchy of</option>
<option>Macau(China)</option>
<option>North Macedonia</option>
<option>Madagascar, Republic of</option>
<option>Malawi, Republic of</option>
<option>Malaysia</option>
<option>Maldives, Republic of</option>
<option>Mali, Republic of</option>
<option>Malta, Republic of</option>
<option>Marshall Islands</option>
<option>Martinique</option>
<option>Mauritania, Islamic Republic of</option>
<option>Mauritius</option>
<option>Mayotte</option>
<option>Mexico, United Mexican States</option>
<option>Micronesia, Federated States of</option>
<option>Moldova, Republic of</option>
<option>Monaco, Principality of</option>
<option>Mongolia, Mongolian People's Republic</option>
<option>Monteserrat</option>
<option>Montenegro</option>
<option>Morocco, Kingdom of</option>
<option>Mozambique, People's Republic</option>
<option>Namibia</option>
<option>Nauru, Republic of</option>
<option>Nepal, Kingdom of</option>
<option>Netherlands, Kingdom of the</option>
<option>New Caledonia</option>
<option>New Zealand</option>
<option>Nicaragua, Republic of</option>
<option>Niger, Republic of the</option>
<option>Nigeria, Rederal Republic of</option>
<option>Niue, Republic of</option>
<option>Norfolk Islands</option>
<option>Northern Mariana Islands</option>
<option>Norway, Kingdom of</option>
<option>Oman, Sultanate of(was Muscat and Oman)</option>
<option>Pakistan, Islamic Republic of</option>
<option>Palau</option>
<option>Palestinian Territory, Occupied</option>
<option>Panama, Republic off</option>
<option>Papua New Guinea</option>
<option>Paraguay, Repblic of</option>
<option>Peru, Republic of</option>
<option>Pitcairn Island</option>
<option>Poland, Republic of</option>
<option>Portugal, Portugenese Republic</option>
<option>Puerto Rico</option>
<option>Qatar</option>
<option>Republic of Kosovo</option>
<option>Reunion</option>
<option>Romania</option>
<option>Russia Federation</option>
<option>Rwanda, Rwandese Republic</option>
<option>Saint Barthelemy</option>
<option>Saint Martin</option>
<option>Samoa, Independent State of(was Western Samoa)</option>
<option>San Marino, Republic of</option>
<option>Sao Tome and Principe, Democratic Republic of</option>
<option>Saudi Arabia, Kingdom of</option>
<option>Serbia</option>
<option>Serbia and Montenegro</option>
<option>Senegal, Republic of</option>
<option>Seychelles, Republic of</option>
<option>Sierra Leone, Republic of</option>
<option>Singapore</option>
<option>Sint Maarten</option>
<option>Slovakia, Slovak Republic</option>
<option>Slovenia</option>
<option>Solomon Islands(was British Solomon Islands)</option>
<option>Somalia, Somali Republic</option>
<option>South Africa, Republic of</option>
<option>South Georgia and the South Sandwich Islands</option>
<option>South Sudan</option>
<option>Spain, Spanish State</option>
<option>Sri Lanka, Democratic Socialist Republic of(was Ceylon)</option>
<option>St. Helena</option>
<option>St. Kitts and Nevis</option>
<option>St. Lucia</option>
<option>St. Pierre and Miquelon</option>
<option>St. Vincent and the Grenadines</option>
<option>Sudan, Democratic Republic of the</option>
<option>Suriname, Republic of</option>
<option>Svalbard & Jan Mayen Islands</option>
<option>Swaziland, Kingdom of</option>
<option>Swedem, Kingdom of</option>
<option>Switzerland, Swiss Confederation</option>
<option>Syrean Arab Republic</option>
<option>Taiwan</option>
<option>Tajikistan</option>
<option>Tanzania, United Republic of</option>
<option>Thailand</option>
<option>Timor-Leste, Democratic Republic of</option>
<option>Togo, Togolese Republic</option>
<option>Tokelau(Tokelau Islands)</option>
<option>Tonga, Kingdom of</option>
<option>Trinidad and Tobago, Republic of</option>
<option>Tunisia, Republic of</option>
<option>Turkey, Republic of</option>
<option>Turkmenistan</option>
<option>Turks and Caicos Islands</option>
<option>Tuvalu(was part of Gilbert & Ellice Islands)</option>
<option>Uganda, Republic of</option>
<option>Ukraine</option>
<option>United Arab Emirates</option>
<option>United Kingdom</option>
<option>United States Minor Outlying Islands</option>
<option>United States of America</option>
<option>Uruguay, Eastern Republic of</option>
<option>US Virgin Islands</option>
<option>Uzbekistan</option>
<option>Vanuatu(was New Herbrides)</option>
<option>Venezuela, Bolivarian Republic of</option>
<option>Vietnam</option>
<option>Wallis and Futun Islands</option>
<option>Western Sahara(was Spanish Sahara)</option>
<option>Yemen</option>
<option>Zambia, Republic of</option>
<option>Zimbabwe(was Southern Rhodesia)</option>
</select>

    </div>

  </div>
</div>

<!-- CONTACT INFORMATION -->
<div class="contact-section">
  <h1>Contact Information</h1>
  <p class="contact-sub">Let us know how we may reach you if there are changes or questions related to your booking and payment. We will also be sending your itinerary to below email.</p>

  <div class="contact-card">
    <div class="toggle-row">
      <label class="switch">
        <input type="checkbox" id="useGuestToggle" checked onchange="toggleGuestSelect()">
        <span class="slider"></span>
      </label>
      Use guest's details
    </div>

    <div id="guestSelectBlock">
      <label class="select-guest-label">Select a guest</label>
      <select id="guestSelect">
        <option value="" selected disabled>Select a guest</option>
      </select>
    </div>

    <div id="manualNameBlock" style="display:none;">
      <span class="field-label">Name</span>
      <div class="row">
        <div style="max-width:110px;">
          <label class="field-label">Title<span class="req">*</span></label>
          <select id="contactTitle">
            <option value="" selected disabled>Select</option>
            <option>Mr.</option>
            <option>Ms.</option>
            <option>Mrs.</option>
          </select>
        </div>
        <div>
          <label class="field-label">First name<span class="req">*</span></label>
          <input type="text" id="contactFirstName" placeholder="Enter first name">
        </div>
        <div>
          <label class="field-label">Last name<span class="req">*</span></label>
          <input type="text" id="contactLastName" placeholder="Enter last name">
        </div>
      </div>

      <label class="no-first-name" style="margin-bottom:18px;">
        <input type="checkbox" id="contactNoFirstName" onchange="toggleContactFirstName()">
        I have no first name <i class="info-icon">i</i>
      </label>
    </div>

    <label class="contact-number-label">Contact Number</label>
    <div class="contact-row">
      <div class="cc">
        <label class="field-label">Country code<span class="req">*</span></label>
        <div class="dropdown" id="countryCodeDropdown">
          <input type="text" class="dropdown-input" id="countryCodeInput" placeholder="Select" readonly>
          <div class="dropdown-list" id="countryCodeList"></div>
        </div>
      </div>
      <div class="mobile">
        <label class="field-label">Mobile number<span class="req">*</span> <i class="info-icon">i</i></label>
        <input type="tel" id="mobileInput" placeholder="e.g. 9998043744" oninput="validateMobile()">
        <span class="error-msg" id="mobileError">Please enter a valid mobile number</span>
      </div>
    </div>

    <div class="row">
      <div>
        <label class="field-label">Email<span class="req">*</span></label>
        <input type="email" id="contactEmail" placeholder="sample@email.com">
      </div>
      <div>
        <label class="field-label">Retype email<span class="req">*</span></label>
        <input type="email" id="contactEmailRetype" placeholder="sample@email.com">
      </div>
    </div>
  </div>

  <div class="terms-card">
    <input type="checkbox" id="termsCheck" onchange="checkFormValid()">
    <span>I confirm that I have read, understood, and agree to the updated Cebu Pacific <a href="#">Privacy Policy</a>. I consent to the collection, use, processing and sharing of my personal information in accordance therewith.</span>
  </div>

  <div class="actions">
    <button class="btn-back" onclick="resetGuestForm(); document.getElementById('guestView').classList.remove('active-view'); document.getElementById('searchView').classList.add('active-view'); window.scrollTo(0,0);">Back</button>
    <button class="btn-continue" id="guestContinueBtn" onclick="handleContinue()">Continue</button>
  </div>
</div>

</div>

<script>
const originBox = document.getElementById('origin-box');
const locationModal = document.getElementById('locationModal');
const australiaBtn = document.getElementById('australiaBtn');
const melbourneBtn = document.getElementById('melbourneBtn');
const sydneyBtn = document.getElementById('sydneyBtn');
const chinaBtn = document.getElementById('chinaBtn');
const guangzhouBtn = document.getElementById('guangzhouBtn');
const shanghaiBtn = document.getElementById('shanghaiBtn');
const shenzhenBtn = document.getElementById('shenzhenBtn');
const xiamenBtn = document.getElementById('xiamenBtn');
const bruneiBtn = document.getElementById('bruneiBtn');
const bandarBtn = document.getElementById('bandarBtn');
const hongKongBtn = document.getElementById('hongKongBtn');
const hongKongCityBtn = document.getElementById('hongKongCityBtn');
const indonesiaBtn = document.getElementById('indonesiaBtn');
const baliBtn = document.getElementById('baliBtn');
const jakartaBtn = document.getElementById('jakartaBtn');
const japanBtn = document.getElementById('japanBtn');
const fukuokaBtn = document.getElementById('fukuokaBtn');
const nagoyaBtn = document.getElementById('nagoyaBtn');
const osakaBtn = document.getElementById('osakaBtn');
const sapporoBtn = document.getElementById('sapporoBtn');
const macauBtn = document.getElementById('macauBtn');
const macauCityBtn = document.getElementById('macauCityBtn');
const malaysiaBtn = document.getElementById('malaysiaBtn');
const kualaLumpurBtn = document.getElementById('kualaLumpurBtn');
const philippinesBtn = document.getElementById('philippinesBtn');
const bacolodBtn = document.getElementById('bacolodBtn');
const boholBtn = document.getElementById('boholBtn');
const boracayBtn = document.getElementById('boracayBtn');
const butuanBtn = document.getElementById('butuanBtn');
const cagayanBtn = document.getElementById('cagayanBtn');
const calbayogBtn = document.getElementById('calbayogBtn');
const camiguinBtn = document.getElementById('camiguinBtn');
const cauayanBtn = document.getElementById('cauayanBtn');
const cebuBtn = document.getElementById('cebuBtn');
const clarkBtn = document.getElementById('clarkBtn');
const coronBtn = document.getElementById('coronBtn');
const cotabatoBtn = document.getElementById('cotabatoBtn');
const davaoBtn = document.getElementById('davaoBtn');
const dipologBtn = document.getElementById('dipologBtn');
const dumagueteBtn = document.getElementById('dumagueteBtn');
const elNidoBtn = document.getElementById('elNidoBtn');
const generalSantosBtn = document.getElementById('generalSantosBtn');
const iloiloBtn = document.getElementById('iloiloBtn');
const kaliboBtn = document.getElementById('kaliboBtn');
const laoagBtn = document.getElementById('laoagBtn');
const legazpiBtn = document.getElementById('legazpiBtn');
const manilaBtn = document.getElementById('manilaBtn');
const masbateBtn = document.getElementById('masbateBtn');
const nagaBtn = document.getElementById('nagaBtn');
const ozamizBtn = document.getElementById('ozamizBtn');
const pagadianBtn = document.getElementById('pagadianBtn');
const puertoPrincesaBtn = document.getElementById('puertoPrincesaBtn');
const roxasBtn = document.getElementById('roxasBtn');
const sanJoseBtn = document.getElementById('sanJoseBtn');
const sanVicenteBtn = document.getElementById('sanVicenteBtn');
const siargaoBtn = document.getElementById('siargaoBtn');
const surigaoBtn = document.getElementById('surigaoBtn');
const taclobanBtn = document.getElementById('taclobanBtn');
const tawiTawiBtn = document.getElementById('tawiTawiBtn');
const tuguegaraoBtn = document.getElementById('tuguegaraoBtn');
const viracBtn = document.getElementById('viracBtn');
const zamboangaBtn = document.getElementById('zamboangaBtn');
const saudiArabiaBtn = document.getElementById('saudiArabiaBtn');
const riyadhBtn = document.getElementById('riyadhBtn');
const singaporeBtn = document.getElementById('singaporeBtn');
const singaporeCityBtn = document.getElementById('singaporeCityBtn');
const southKoreaBtn = document.getElementById('southKoreaBtn');
const seoulBtn = document.getElementById('seoulBtn');
const taiwanBtn = document.getElementById('taiwanBtn');
const kaohsiungBtn = document.getElementById('kaohsiungBtn');
const taipeiBtn = document.getElementById('taipeiBtn');
const thailandBtn = document.getElementById('thailandBtn');
const bangkokDonMueangBtn = document.getElementById('bangkokDonMueangBtn');
const bangkokSuvarnabhumiBtn = document.getElementById('bangkokSuvarnabhumiBtn');
const chiangMaiBtn = document.getElementById('chiangMaiBtn');
const uaeBtn = document.getElementById('uaeBtn');
const dubaiBtn = document.getElementById('dubaiBtn');
const vietnamBtn = document.getElementById('vietnamBtn');
const daNangBtn = document.getElementById('daNangBtn');
const hanoiBtn = document.getElementById('hanoiBtn');
const hoChiMinhBtn = document.getElementById('hoChiMinhBtn');

const originInput = document.getElementById('origin-input');
const destinationBox = document.getElementById('destination-box');
const destinationLocationModal = document.getElementById('destinationLocationModal');
const destinationInput = document.getElementById('destination-input');
const swapBtn = document.getElementById('swapBtn');

const destAustraliaBtn = document.getElementById('dest-australiaBtn');
const destMelbourneBtn = document.getElementById('dest-melbourneBtn');
const destSydneyBtn = document.getElementById('dest-sydneyBtn');
const destChinaBtn = document.getElementById('dest-chinaBtn');
const destGuangzhouBtn = document.getElementById('dest-guangzhouBtn');
const destShanghaiBtn = document.getElementById('dest-shanghaiBtn');
const destShenzhenBtn = document.getElementById('dest-shenzhenBtn');
const destXiamenBtn = document.getElementById('dest-xiamenBtn');
const destBruneiBtn = document.getElementById('dest-bruneiBtn');
const destBandarBtn = document.getElementById('dest-bandarBtn');
const destHongKongBtn = document.getElementById('dest-hongKongBtn');
const destHongKongCityBtn = document.getElementById('dest-hongKongCityBtn');
const destIndonesiaBtn = document.getElementById('dest-indonesiaBtn');
const destBaliBtn = document.getElementById('dest-baliBtn');
const destJakartaBtn = document.getElementById('dest-jakartaBtn');
const destJapanBtn = document.getElementById('dest-japanBtn');
const destFukuokaBtn = document.getElementById('dest-fukuokaBtn');
const destNagoyaBtn = document.getElementById('dest-nagoyaBtn');
const destOsakaBtn = document.getElementById('dest-osakaBtn');
const destSapporoBtn = document.getElementById('dest-sapporoBtn');
const destMacauBtn = document.getElementById('dest-macauBtn');
const destMacauCityBtn = document.getElementById('dest-macauCityBtn');
const destMalaysiaBtn = document.getElementById('dest-malaysiaBtn');
const destKualaLumpurBtn = document.getElementById('dest-kualaLumpurBtn');
const destPhilippinesBtn = document.getElementById('dest-philippinesBtn');
const destBacolodBtn = document.getElementById('dest-bacolodBtn');
const destBoholBtn = document.getElementById('dest-boholBtn');
const destBoracayBtn = document.getElementById('dest-boracayBtn');
const destButuanBtn = document.getElementById('dest-butuanBtn');
const destCagayanBtn = document.getElementById('dest-cagayanBtn');
const destCalbayogBtn = document.getElementById('dest-calbayogBtn');
const destCamiguinBtn = document.getElementById('dest-camiguinBtn');
const destCauayanBtn = document.getElementById('dest-cauayanBtn');
const destCebuBtn = document.getElementById('dest-cebuBtn');
const destClarkBtn = document.getElementById('dest-clarkBtn');
const destCoronBtn = document.getElementById('dest-coronBtn');
const destCotabatoBtn = document.getElementById('dest-cotabatoBtn');
const destDavaoBtn = document.getElementById('dest-davaoBtn');
const destDipologBtn = document.getElementById('dest-dipologBtn');
const destDumagueteBtn = document.getElementById('dest-dumagueteBtn');
const destElNidoBtn = document.getElementById('dest-elNidoBtn');
const destGeneralSantosBtn = document.getElementById('dest-generalSantosBtn');
const destIloiloBtn = document.getElementById('dest-iloiloBtn');
const destKaliboBtn = document.getElementById('dest-kaliboBtn');
const destLaoagBtn = document.getElementById('dest-laoagBtn');
const destLegazpiBtn = document.getElementById('dest-legazpiBtn');
const destManilaBtn = document.getElementById('dest-manilaBtn');
const destMasbateBtn = document.getElementById('dest-masbateBtn');
const destNagaBtn = document.getElementById('dest-nagaBtn');
const destOzamizBtn = document.getElementById('dest-ozamizBtn');
const destPagadianBtn = document.getElementById('dest-pagadianBtn');
const destPuertoPrincesaBtn = document.getElementById('dest-puertoPrincesaBtn');
const destRoxasBtn = document.getElementById('dest-roxasBtn');
const destSanJoseBtn = document.getElementById('dest-sanJoseBtn');
const destSanVicenteBtn = document.getElementById('dest-sanVicenteBtn');
const destSiargaoBtn = document.getElementById('dest-siargaoBtn');
const destSurigaoBtn = document.getElementById('dest-surigaoBtn');
const destTaclobanBtn = document.getElementById('dest-taclobanBtn');
const destTawiTawiBtn = document.getElementById('dest-tawiTawiBtn');
const destTuguegaraoBtn = document.getElementById('dest-tuguegaraoBtn');
const destViracBtn = document.getElementById('dest-viracBtn');
const destZamboangaBtn = document.getElementById('dest-zamboangaBtn');
const destSaudiArabiaBtn = document.getElementById('dest-saudiArabiaBtn');
const destRiyadhBtn = document.getElementById('dest-riyadhBtn');
const destSingaporeBtn = document.getElementById('dest-singaporeBtn');
const destSingaporeCityBtn = document.getElementById('dest-singaporeCityBtn');
const destSouthKoreaBtn = document.getElementById('dest-southKoreaBtn');
const destSeoulBtn = document.getElementById('dest-seoulBtn');
const destTaiwanBtn = document.getElementById('dest-taiwanBtn');
const destKaohsiungBtn = document.getElementById('dest-kaohsiungBtn');
const destTaipeiBtn = document.getElementById('dest-taipeiBtn');
const destThailandBtn = document.getElementById('dest-thailandBtn');
const destBangkokDonMueangBtn = document.getElementById('dest-bangkokDonMueangBtn');
const destBangkokSuvarnabhumiBtn = document.getElementById('dest-bangkokSuvarnabhumiBtn');
const destChiangMaiBtn = document.getElementById('dest-chiangMaiBtn');
const destUaeBtn = document.getElementById('dest-uaeBtn');
const destDubaiBtn = document.getElementById('dest-dubaiBtn');
const destVietnamBtn = document.getElementById('dest-vietnamBtn');
const destDaNangBtn = document.getElementById('dest-daNangBtn');
const destHanoiBtn = document.getElementById('dest-hanoiBtn');
const destHoChiMinhBtn = document.getElementById('dest-hoChiMinhBtn');

// Page navigation connecting logic
const searchFlightsBtn = document.getElementById('searchFlightsBtn');
const searchView = document.getElementById('searchView');
const selectView = document.getElementById('selectView');
const routeCities = document.getElementById('routeCities');
const summaryRouteText = document.getElementById('summaryRouteText');
const summaryDatesText = document.getElementById('summaryDatesText');
const summaryGuestsText = document.getElementById('summaryGuestsText');
const backToSearchBtn = document.getElementById('backToSearchBtn');
const modifySearchBtn = document.getElementById('modifySearchBtn');

function goToSearchPage() {
  selectView.classList.remove('active-view');
  searchView.classList.add('active-view');
  window.scrollTo(0, 0);
}

backToSearchBtn.addEventListener('click', goToSearchPage);
modifySearchBtn.addEventListener('click', goToSearchPage);

searchFlightsBtn.addEventListener('click', function () {
  if (searchFlightsBtn.disabled) return;
  if (originInput.value && destinationInput.value) {
    const routeString = `${originInput.value} to ${destinationInput.value}`;
    routeCities.innerText = routeString;
    summaryRouteText.innerText = routeString;
  }
  // Update Summary Strip Dates & Guests
  if (departInput.value) {
    if (returnInput.value) {
      summaryDatesText.innerText = `${departInput.value} - ${returnInput.value}`;
    } else {
      summaryDatesText.innerText = departInput.value;
    }
  }
  const adultsCount = parseInt(document.getElementById('adults-select').value) || 1;
  const childrenCount = parseInt(document.getElementById('children-select').value) || 0;
  const totalGuests = adultsCount + childrenCount;
  summaryGuestsText.innerText = `${totalGuests} Guest${totalGuests > 1 ? 's' : ''}`;

  // Initialize or sync selected date strip anchor date
  if (startDate) {
    stripAnchorDate = new Date(startDate);
    renderDateStrip();
    filterFlightsByDate(startDate);
  }

  // Show/build the Returning Flight section (inserted) for round-trip searches
  if (typeof updateReturnSectionVisibility === 'function') {
    updateReturnSectionVisibility();
  }

  searchView.classList.remove('active-view');
  selectView.classList.add('active-view');
  window.scrollTo(0, 0);
});

// Trip type dropdown handling
const tripTypeBtn = document.getElementById('tripTypeBtn');
const tripDropdown = document.getElementById('tripDropdown');
const tripRoundOption = document.getElementById('tripRoundOption');
const tripOneWayOption = document.getElementById('tripOneWayOption');
const returnBoxContainer = document.getElementById('return-box').closest('.form-group');

tripTypeBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  locationModal.classList.remove('active');
  destinationLocationModal.classList.remove('active');
  calendarModal.classList.remove('active');
  tripDropdown.classList.toggle('active');
});

tripRoundOption.addEventListener('click', function (e) {
  e.stopPropagation();
  tripTypeBtn.innerText = 'Round-trip';
  tripDropdown.classList.remove('active');
  returnBoxContainer.style.display = 'flex';
});

tripOneWayOption.addEventListener('click', function (e) {
  e.stopPropagation();
  tripTypeBtn.innerText = 'One-way';
  tripDropdown.classList.remove('active');
  returnBoxContainer.style.display = 'none';
  endDate = null;
  returnInput.value = '';
  returnInput.placeholder = 'Returning on';
});

// Swap functionality for the swap button
swapBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  const temp = originInput.value;
  originInput.value = destinationInput.value;
  destinationInput.value = temp;
});

originBox.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationLocationModal.classList.remove('active');
  calendarModal.classList.remove('active');
  tripDropdown.classList.remove('active');
  departBox.classList.remove('active-tab');
  locationModal.classList.toggle('active');
});

destinationBox.addEventListener('click', function (e) {
  e.stopPropagation();
  locationModal.classList.remove('active');
  calendarModal.classList.remove('active');
  tripDropdown.classList.remove('active');
  departBox.classList.remove('active-tab');
  destinationLocationModal.classList.toggle('active');
});

/* Calendar Interaction Logic */
const departBox = document.getElementById('depart-box');
const returnBox = document.getElementById('return-box');
const calendarModal = document.getElementById('calendarModal');
const departInput = document.getElementById('depart-input');
const returnInput = document.getElementById('return-input');
const selectDatesBtn = document.getElementById('selectDatesBtn');
const month1Grid = document.getElementById('month1Grid');
const month2Grid = document.getElementById('month2Grid');
const month1Label = document.getElementById('month1Label');
const month2Label = document.getElementById('month2Label');
const prevMonthBtn = document.getElementById('prevMonthBtn');
const nextMonthBtn = document.getElementById('nextMonthBtn');

// Today's date baseline for disabling past dates (always the real current date)
const today = new Date();
today.setHours(0, 0, 0, 0);

let currentYear = today.getFullYear();
let currentMonth = today.getMonth(); // 0-indexed

// Default selected dates now start from today instead of a fixed date
let startDate = new Date(today);
let endDate = null;

// Sync the visible Depart field and top summary bar to today's real date
// (they start out as static placeholder text in the HTML).
const initDaysShort = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
departInput.value = formatDate(startDate);
summaryDatesText.innerText = `${initDaysShort[startDate.getDay()]}, ${formatDate(startDate)}`;

function openCalendar(e) {
  e.stopPropagation();
  locationModal.classList.remove('active');
  destinationLocationModal.classList.remove('active');
  tripDropdown.classList.remove('active');
  calendarModal.classList.add('active');
  departBox.classList.add('active-tab');
  renderCalendar();
}

departBox.addEventListener('click', openCalendar);
returnBox.addEventListener('click', openCalendar);

prevMonthBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar();
});

nextMonthBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar();
});

function formatDate(date) {
  if (!date) return '';
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const day = String(date.getDate()).padStart(2, '0');
  const month = months[date.getMonth()];
  const year = date.getFullYear();
  return `${day} ${month} ${year}`;
}

function renderMonth(year, month, gridElement, labelElement) {
  const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  labelElement.innerText = `${monthNames[month]} ${year}`;
  gridElement.innerHTML = '';

  const firstDayIndex = new Date(year, month, 1).getDay();
  const totalDays = new Date(year, month + 1, 0).getDate();

  // Blank slots for previous month trailing days
  for (let i = 0; i < firstDayIndex; i++) {
    const emptyDiv = document.createElement('div');
    emptyDiv.classList.add('calendar-day', 'empty');
    gridElement.appendChild(emptyDiv);
  }

  // Days of current month
  for (let day = 1; day <= totalDays; day++) {
    const dayDiv = document.createElement('div');
    dayDiv.classList.add('calendar-day');
    dayDiv.innerText = day;

    const thisDate = new Date(year, month, day);
    thisDate.setHours(0, 0, 0, 0);

    // Disable past dates
    if (thisDate < today) {
      dayDiv.classList.add('disabled');
    } else {
      // Highlight status check
      if (startDate && thisDate.toDateString() === startDate.toDateString()) {
        dayDiv.classList.add('selected-start');
      }
      if (endDate && thisDate.toDateString() === endDate.toDateString()) {
        dayDiv.classList.add('selected-end');
      }
      if (startDate && endDate && thisDate > startDate && thisDate < endDate) {
        dayDiv.classList.add('in-range');
      }

      dayDiv.addEventListener('click', function (e) {
        e.stopPropagation();
        handleDateSelection(thisDate);
      });
    }
    gridElement.appendChild(dayDiv);
  }
}

function renderCalendar() {
  renderMonth(currentYear, currentMonth, month1Grid, month1Label);
  let nextMonth = currentMonth + 1;
  let nextYear = currentYear;
  if (nextMonth > 11) {
    nextMonth = 0;
    nextYear++;
  }
  renderMonth(nextYear, nextMonth, month2Grid, month2Label);
  updateConfirmButtonState();
}

function handleDateSelection(date) {
  if (tripTypeBtn.innerText === 'One-way') {
    startDate = date;
    endDate = null;
    departInput.value = formatDate(startDate);
    calendarModal.classList.remove('active');
    departBox.classList.remove('active-tab');
  } else {
    if (!startDate || (startDate && endDate)) {
      startDate = date;
      endDate = null;
      departInput.value = formatDate(startDate);
      returnInput.value = '';
      returnInput.placeholder = 'Returning on';
    } else if (startDate && !endDate) {
      if (date < startDate) {
        startDate = date;
        departInput.value = formatDate(startDate);
      } else {
        endDate = date;
        returnInput.value = formatDate(endDate);
      }
    }
  }
  renderCalendar();
}

function updateConfirmButtonState() {
  if (tripTypeBtn.innerText === 'One-way') {
    selectDatesBtn.classList.add('active-confirm');
  } else if (startDate && endDate) {
    selectDatesBtn.classList.add('active-confirm');
  } else {
    selectDatesBtn.classList.remove('active-confirm');
  }
}

selectDatesBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  if (tripTypeBtn.innerText === 'One-way' && startDate) {
    calendarModal.classList.remove('active');
    departBox.classList.remove('active-tab');
  } else if (startDate && endDate) {
    calendarModal.classList.remove('active');
    departBox.classList.remove('active-tab');
  }
});

australiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  melbourneBtn.classList.toggle('show');
  sydneyBtn.classList.toggle('show');
});

chinaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  guangzhouBtn.classList.toggle('show');
  shanghaiBtn.classList.toggle('show');
  shenzhenBtn.classList.toggle('show');
  xiamenBtn.classList.toggle('show');
});

bruneiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  bandarBtn.classList.toggle('show');
});

hongKongBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  hongKongCityBtn.classList.toggle('show');
});

indonesiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  baliBtn.classList.toggle('show');
  jakartaBtn.classList.toggle('show');
});

japanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  fukuokaBtn.classList.toggle('show');
  nagoyaBtn.classList.toggle('show');
  osakaBtn.classList.toggle('show');
  sapporoBtn.classList.toggle('show');
});

macauBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  macauCityBtn.classList.toggle('show');
});

malaysiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  kualaLumpurBtn.classList.toggle('show');
});

philippinesBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  bacolodBtn.classList.toggle('show');
  boholBtn.classList.toggle('show');
  boracayBtn.classList.toggle('show');
  butuanBtn.classList.toggle('show');
  cagayanBtn.classList.toggle('show');
  calbayogBtn.classList.toggle('show');
  camiguinBtn.classList.toggle('show');
  cauayanBtn.classList.toggle('show');
  cebuBtn.classList.toggle('show');
  clarkBtn.classList.toggle('show');
  coronBtn.classList.toggle('show');
  cotabatoBtn.classList.toggle('show');
  davaoBtn.classList.toggle('show');
  dipologBtn.classList.toggle('show');
  dumagueteBtn.classList.toggle('show');
  elNidoBtn.classList.toggle('show');
  generalSantosBtn.classList.toggle('show');
  iloiloBtn.classList.toggle('show');
  kaliboBtn.classList.toggle('show');
  laoagBtn.classList.toggle('show');
  legazpiBtn.classList.toggle('show');
  manilaBtn.classList.toggle('show');
  masbateBtn.classList.toggle('show');
  nagaBtn.classList.toggle('show');
  ozamizBtn.classList.toggle('show');
  pagadianBtn.classList.toggle('show');
  puertoPrincesaBtn.classList.toggle('show');
  roxasBtn.classList.toggle('show');
  sanJoseBtn.classList.toggle('show');
  sanVicenteBtn.classList.toggle('show');
  siargaoBtn.classList.toggle('show');
  surigaoBtn.classList.toggle('show');
  taclobanBtn.classList.toggle('show');
  tawiTawiBtn.classList.toggle('show');
  tuguegaraoBtn.classList.toggle('show');
  viracBtn.classList.toggle('show');
  zamboangaBtn.classList.toggle('show');
});

saudiArabiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  riyadhBtn.classList.toggle('show');
});

singaporeBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  singaporeCityBtn.classList.toggle('show');
});

southKoreaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  seoulBtn.classList.toggle('show');
});

taiwanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  kaohsiungBtn.classList.toggle('show');
  taipeiBtn.classList.toggle('show');
});

thailandBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  bangkokDonMueangBtn.classList.toggle('show');
  bangkokSuvarnabhumiBtn.classList.toggle('show');
  chiangMaiBtn.classList.toggle('show');
});

uaeBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  dubaiBtn.classList.toggle('show');
});

vietnamBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  daNangBtn.classList.toggle('show');
  hanoiBtn.classList.toggle('show');
  hoChiMinhBtn.classList.toggle('show');
});

destAustraliaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destMelbourneBtn.classList.toggle('show');
  destSydneyBtn.classList.toggle('show');
});

destChinaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destGuangzhouBtn.classList.toggle('show');
  destShanghaiBtn.classList.toggle('show');
  destShenzhenBtn.classList.toggle('show');
  destXiamenBtn.classList.toggle('show');
});

destBruneiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destBandarBtn.classList.toggle('show');
});

destHongKongBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destHongKongCityBtn.classList.toggle('show');
});

destIndonesiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destBaliBtn.classList.toggle('show');
  destJakartaBtn.classList.toggle('show');
});

destJapanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destFukuokaBtn.classList.toggle('show');
  destNagoyaBtn.classList.toggle('show');
  destOsakaBtn.classList.toggle('show');
  destSapporoBtn.classList.toggle('show');
});

destMacauBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destMacauCityBtn.classList.toggle('show');
});

destMalaysiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destKualaLumpurBtn.classList.toggle('show');
});

destPhilippinesBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destBacolodBtn.classList.toggle('show');
  destBoholBtn.classList.toggle('show');
  destBoracayBtn.classList.toggle('show');
  destButuanBtn.classList.toggle('show');
  destCagayanBtn.classList.toggle('show');
  destCalbayogBtn.classList.toggle('show');
  destCamiguinBtn.classList.toggle('show');
  destCauayanBtn.classList.toggle('show');
  destCebuBtn.classList.toggle('show');
  destClarkBtn.classList.toggle('show');
  destCoronBtn.classList.toggle('show');
  destCotabatoBtn.classList.toggle('show');
  destDavaoBtn.classList.toggle('show');
  destDipologBtn.classList.toggle('show');
  destDumagueteBtn.classList.toggle('show');
  destElNidoBtn.classList.toggle('show');
  destGeneralSantosBtn.classList.toggle('show');
  destIloiloBtn.classList.toggle('show');
  destKaliboBtn.classList.toggle('show');
  destLaoagBtn.classList.toggle('show');
  destLegazpiBtn.classList.toggle('show');
  destManilaBtn.classList.toggle('show');
  destMasbateBtn.classList.toggle('show');
  destNagaBtn.classList.toggle('show');
  destOzamizBtn.classList.toggle('show');
  destPagadianBtn.classList.toggle('show');
  destPuertoPrincesaBtn.classList.toggle('show');
  destRoxasBtn.classList.toggle('show');
  destSanJoseBtn.classList.toggle('show');
  destSanVicenteBtn.classList.toggle('show');
  destSiargaoBtn.classList.toggle('show');
  destSurigaoBtn.classList.toggle('show');
  destTaclobanBtn.classList.toggle('show');
  destTawiTawiBtn.classList.toggle('show');
  destTuguegaraoBtn.classList.toggle('show');
  destViracBtn.classList.toggle('show');
  destZamboangaBtn.classList.toggle('show');
});

destSaudiArabiaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destRiyadhBtn.classList.toggle('show');
});

destSingaporeBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destSingaporeCityBtn.classList.toggle('show');
});

destSouthKoreaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destSeoulBtn.classList.toggle('show');
});

destTaiwanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destKaohsiungBtn.classList.toggle('show');
  destTaipeiBtn.classList.toggle('show');
});

destThailandBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destBangkokDonMueangBtn.classList.toggle('show');
  destBangkokSuvarnabhumiBtn.classList.toggle('show');
  destChiangMaiBtn.classList.toggle('show');
});

destUaeBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destDubaiBtn.classList.toggle('show');
});

destVietnamBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destDaNangBtn.classList.toggle('show');
  destHanoiBtn.classList.toggle('show');
  destHoChiMinhBtn.classList.toggle('show');
});

function updateDestinationAvailability(selectedCity) {
  const allDestCities = document.querySelectorAll('.dest-city-item');
  allDestCities.forEach(cityEl => {
    if (cityEl.getAttribute('data-city-name') === selectedCity) {
      cityEl.style.display = 'none';
      cityEl.classList.remove('show');
    } else {
      cityEl.style.display = '';
    }
  });
}

melbourneBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Melbourne';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Melbourne');
});
sydneyBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Sydney';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Sydney');
});
guangzhouBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Guangzhou (Canton)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Guangzhou (Canton)');
});
shanghaiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Shanghai';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Shanghai');
});
shenzhenBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Shenzhen';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Shenzhen');
});
xiamenBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Xiamen';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Xiamen');
});
bandarBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Bandar Seri Begawan (Brunei)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Bandar Seri Begawan (Brunei)');
});
hongKongCityBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'HongKong';
  locationModal.classList.remove('active');
  updateDestinationAvailability('HongKong');
});
baliBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Bali (Denpasar)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Bali (Denpasar)');
});
jakartaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Jakarta';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Jakarta');
});
fukuokaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Fukuoka';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Fukuoka');
});
nagoyaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Nagoya';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Nagoya');
});
osakaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Osaka (Kansai)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Osaka (Kansai)');
});
sapporoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Sapporo (New Chitose)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Sapporo (New Chitose)');
});
macauCityBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Macau';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Macau');
});
kualaLumpurBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Kuala Lumpur';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Kuala Lumpur');
});
bacolodBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Bacolod';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Bacolod');
});
boholBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Bohol';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Bohol');
});
boracayBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Boracay (Caticlan)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Boracay (Caticlan)');
});
butuanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Butuan';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Butuan');
});
cagayanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Cagayan de Oro';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Cagayan de Oro');
});
calbayogBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Calbayog';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Calbayog');
});
camiguinBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Camiguin';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Camiguin');
});
cauayanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Cauayan';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Cauayan');
});
cebuBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Cebu';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Cebu');
});
clarkBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Clark';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Clark');
});
coronBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Coron (Busuanga)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Coron (Busuanga)');
});
cotabatoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Cotabato';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Cotabato');
});
davaoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Davao';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Davao');
});
dipologBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Dipolog';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Dipolog');
});
dumagueteBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Dumaguete';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Dumaguete');
});
elNidoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'El Nido';
  locationModal.classList.remove('active');
  updateDestinationAvailability('El Nido');
});
generalSantosBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'General Santos';
  locationModal.classList.remove('active');
  updateDestinationAvailability('General Santos');
});
iloiloBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Iloilo';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Iloilo');
});
kaliboBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Kalibo';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Kalibo');
});
laoagBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Laoag';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Laoag');
});
legazpiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Legazpi (Daraga)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Legazpi (Daraga)');
});
manilaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Manila';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Manila');
});
masbateBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Masbate';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Masbate');
});
nagaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Naga';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Naga');
});
ozamizBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Ozamiz';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Ozamiz');
});
pagadianBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Pagadian';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Pagadian');
});
puertoPrincesaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Puerto Princesa';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Puerto Princesa');
});
roxasBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Roxas';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Roxas');
});
sanJoseBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'San Jose (Mindoro)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('San Jose (Mindoro)');
});
sanVicenteBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'San Vicente (Port Barton)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('San Vicente (Port Barton)');
});
siargaoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Siargao';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Siargao');
});
surigaoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Surigao';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Surigao');
});
taclobanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Tacloban';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Tacloban');
});
tawiTawiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Tawi-Tawi';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Tawi-Tawi');
});
tuguegaraoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Tuguegarao';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Tuguegarao');
});
viracBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Virac';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Virac');
});
zamboangaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Zamboanga';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Zamboanga');
});
riyadhBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Riyadh';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Riyadh');
});
singaporeCityBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Singapore';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Singapore');
});
seoulBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Seoul (Incheon)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Seoul (Incheon)');
});
kaohsiungBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Kaohsiung';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Kaohsiung');
});
taipeiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Taipei';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Taipei');
});
bangkokDonMueangBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Bangkok (Don Mueang)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Bangkok (Don Mueang)');
});
bangkokSuvarnabhumiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Bangkok (Suvarnabhumi)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Bangkok (Suvarnabhumi)');
});
chiangMaiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Chiang Mai';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Chiang Mai');
});
dubaiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Dubai';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Dubai');
});
daNangBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Da Nang';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Da Nang');
});
hanoiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Hanoi';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Hanoi');
});
hoChiMinhBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  originInput.value = 'Ho Chi Minh (Saigon)';
  locationModal.classList.remove('active');
  updateDestinationAvailability('Ho Chi Minh (Saigon)');
});

destMelbourneBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Melbourne';
  destinationLocationModal.classList.remove('active');
});
destSydneyBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Sydney';
  destinationLocationModal.classList.remove('active');
});
destGuangzhouBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Guangzhou (Canton)';
  destinationLocationModal.classList.remove('active');
});
destShanghaiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Shanghai';
  destinationLocationModal.classList.remove('active');
});
destShenzhenBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Shenzhen';
  destinationLocationModal.classList.remove('active');
});
destXiamenBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Xiamen';
  destinationLocationModal.classList.remove('active');
});
destBandarBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Bandar Seri Begawan (Brunei)';
  destinationLocationModal.classList.remove('active');
});
destHongKongCityBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'HongKong';
  destinationLocationModal.classList.remove('active');
});
destBaliBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Bali (Denpasar)';
  destinationLocationModal.classList.remove('active');
});
destJakartaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Jakarta';
  destinationLocationModal.classList.remove('active');
});
destFukuokaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Fukuoka';
  destinationLocationModal.classList.remove('active');
});
destNagoyaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Nagoya';
  destinationLocationModal.classList.remove('active');
});
destOsakaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Osaka (Kansai)';
  destinationLocationModal.classList.remove('active');
});
destSapporoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Sapporo (New Chitose)';
  destinationLocationModal.classList.remove('active');
});
destMacauCityBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Macau';
  destinationLocationModal.classList.remove('active');
});
destKualaLumpurBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Kuala Lumpur';
  destinationLocationModal.classList.remove('active');
});
destBacolodBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Bacolod';
  destinationLocationModal.classList.remove('active');
});
destBoholBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Bohol';
  destinationLocationModal.classList.remove('active');
});
destBoracayBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Boracay (Caticlan)';
  destinationLocationModal.classList.remove('active');
});
destButuanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Butuan';
  destinationLocationModal.classList.remove('active');
});
destCagayanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Cagayan de Oro';
  destinationLocationModal.classList.remove('active');
});
destCalbayogBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Calbayog';
  destinationLocationModal.classList.remove('active');
});
destCamiguinBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Camiguin';
  destinationLocationModal.classList.remove('active');
});
destCauayanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Cauayan';
  destinationLocationModal.classList.remove('active');
});
destCebuBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Cebu';
  destinationLocationModal.classList.remove('active');
});
destClarkBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Clark';
  destinationLocationModal.classList.remove('active');
});
destCoronBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Coron (Busuanga)';
  destinationLocationModal.classList.remove('active');
});
destCotabatoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Cotabato';
  destinationLocationModal.classList.remove('active');
});
destDavaoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Davao';
  destinationLocationModal.classList.remove('active');
});
destDipologBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Dipolog';
  destinationLocationModal.classList.remove('active');
});
destDumagueteBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Dumaguete';
  destinationLocationModal.classList.remove('active');
});
destElNidoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'El Nido';
  destinationLocationModal.classList.remove('active');
});
destGeneralSantosBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'General Santos';
  destinationLocationModal.classList.remove('active');
});
destIloiloBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Iloilo';
  destinationLocationModal.classList.remove('active');
});
destKaliboBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Kalibo';
  destinationLocationModal.classList.remove('active');
});
destLaoagBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Laoag';
  destinationLocationModal.classList.remove('active');
});
destLegazpiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Legazpi (Daraga)';
  destinationLocationModal.classList.remove('active');
});
destManilaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Manila';
  destinationLocationModal.classList.remove('active');
});
destMasbateBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Masbate';
  destinationLocationModal.classList.remove('active');
});
destNagaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Naga';
  destinationLocationModal.classList.remove('active');
});
destOzamizBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Ozamiz';
  destinationLocationModal.classList.remove('active');
});
destPagadianBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Pagadian';
  destinationLocationModal.classList.remove('active');
});
destPuertoPrincesaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Puerto Princesa';
  destinationLocationModal.classList.remove('active');
});
destRoxasBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Roxas';
  destinationLocationModal.classList.remove('active');
});
destSanJoseBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'San Jose (Mindoro)';
  destinationLocationModal.classList.remove('active');
});
destSanVicenteBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'San Vicente (Port Barton)';
  destinationLocationModal.classList.remove('active');
});
destSiargaoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Siargao';
  destinationLocationModal.classList.remove('active');
});
destSurigaoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Surigao';
  destinationLocationModal.classList.remove('active');
});
destTaclobanBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Tacloban';
  destinationLocationModal.classList.remove('active');
});
destTawiTawiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Tawi-Tawi';
  destinationLocationModal.classList.remove('active');
});
destTuguegaraoBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Tuguegarao';
  destinationLocationModal.classList.remove('active');
});
destViracBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Virac';
  destinationLocationModal.classList.remove('active');
});
destZamboangaBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Zamboanga';
  destinationLocationModal.classList.remove('active');
});
destRiyadhBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Riyadh';
  destinationLocationModal.classList.remove('active');
});
destSingaporeCityBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Singapore';
  destinationLocationModal.classList.remove('active');
});
destSeoulBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Seoul (Incheon)';
  destinationLocationModal.classList.remove('active');
});
destKaohsiungBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Kaohsiung';
  destinationLocationModal.classList.remove('active');
});
destTaipeiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Taipei';
  destinationLocationModal.classList.remove('active');
});
destBangkokDonMueangBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Bangkok (Don Mueang)';
  destinationLocationModal.classList.remove('active');
});
destBangkokSuvarnabhumiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Bangkok (Suvarnabhumi)';
  destinationLocationModal.classList.remove('active');
});
destChiangMaiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Chiang Mai';
  destinationLocationModal.classList.remove('active');
});
destDubaiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Dubai';
  destinationLocationModal.classList.remove('active');
});
destDaNangBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Da Nang';
  destinationLocationModal.classList.remove('active');
});
destHanoiBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Hanoi';
  destinationLocationModal.classList.remove('active');
});
destHoChiMinhBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  destinationInput.value = 'Ho Chi Minh (Saigon)';
  destinationLocationModal.classList.remove('active');
});

// Close modals when clicking outside
document.addEventListener('click', function () {
  locationModal.classList.remove('active');
  destinationLocationModal.classList.remove('active');
  calendarModal.classList.remove('active');
  tripDropdown.classList.remove('active');
  sortMenu.classList.remove('active');
  departBox.classList.remove('active-tab');
  timeFilterMenu.classList.remove('active');
  stopsFilterMenu.classList.remove('active');
  // Returning-flight menus (inserted)
  if (typeof retTimeFilterMenu !== 'undefined' && retTimeFilterMenu) retTimeFilterMenu.classList.remove('active');
  if (typeof retStopsFilterMenu !== 'undefined' && retStopsFilterMenu) retStopsFilterMenu.classList.remove('active');
  if (typeof retSortMenu !== 'undefined' && retSortMenu) retSortMenu.classList.remove('active');
});

/* TIME OF FLIGHT & STOPS FILTER LOGIC */
const timeFilterBtn = document.getElementById('timeFilterBtn');
const timeFilterMenu = document.getElementById('timeFilterMenu');
const departureTab = document.getElementById('departureTab');
const arrivalTab = document.getElementById('arrivalTab');
const timeFilterReset = document.getElementById('timeFilterReset');
const timeFilterApply = document.getElementById('timeFilterApply');
const stopsFilterBtn = document.getElementById('stopsFilterBtn');
const stopsFilterMenu = document.getElementById('stopsFilterMenu');
const stopsFilterReset = document.getElementById('stopsFilterReset');
const stopsFilterApply = document.getElementById('stopsFilterApply');

let timeFilterMode = 'departure';
let activeTimeRanges = [];
let activeStops = [];

/* Fix: clicking a checkbox (or its label) inside these menus was bubbling
   up to the document-level "click outside closes menus" handler above,
   closing the dropdown immediately after a single selection. Stopping
   propagation for any click within the menu itself allows multiple
   checkboxes to be selected before Apply/Reset/outside-click closes it. */
timeFilterMenu.addEventListener('click', function (e) {
  e.stopPropagation();
});
stopsFilterMenu.addEventListener('click', function (e) {
  e.stopPropagation();
});

function getMinutesFromTimeStr(str) {
  const parts = String(str || '0:0').split(':');
  return (parseInt(parts[0], 10) || 0) * 60 + (parseInt(parts[1], 10) || 0);
}

function getCardArrivalTimeStr(card) {
  const times = card.querySelectorAll('.time-group .time');
  return times.length > 1 ? times[1].innerText : card.getAttribute('data-depart');
}

function passesTimeFilter(card) {
  if (activeTimeRanges.length === 0) return true;
  const timeStr = timeFilterMode === 'arrival' ? getCardArrivalTimeStr(card) : card.getAttribute('data-depart');
  const minutes = getMinutesFromTimeStr(timeStr) % 1440;
  return activeTimeRanges.some(function (range) {
    const bounds = range.split('-').map(Number);
    return minutes >= bounds[0] && minutes <= bounds[1];
  });
}

function passesStopsFilter(card) {
  if (activeStops.length === 0) return true;
  const badge = card.querySelector('.direct-badge');
  const stopsLabel = badge ? badge.innerText.trim() : 'Direct';
  return activeStops.indexOf(stopsLabel) !== -1;
}

function applyCardFilters() {
  const cards = flightsContainer.querySelectorAll('.flight-card');
  cards.forEach(function (card) {
    card.style.display = (passesTimeFilter(card) && passesStopsFilter(card)) ? 'flex' : 'none';
  });
}

timeFilterBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  stopsFilterMenu.classList.remove('active');
  sortMenu.classList.remove('active');
  timeFilterMenu.classList.toggle('active');
});

stopsFilterBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  timeFilterMenu.classList.remove('active');
  sortMenu.classList.remove('active');
  stopsFilterMenu.classList.toggle('active');
});

departureTab.addEventListener('click', function (e) {
  e.stopPropagation();
  timeFilterMode = 'departure';
  departureTab.classList.add('active');
  arrivalTab.classList.remove('active');
});

arrivalTab.addEventListener('click', function (e) {
  e.stopPropagation();
  timeFilterMode = 'arrival';
  arrivalTab.classList.add('active');
  departureTab.classList.remove('active');
});

timeFilterReset.addEventListener('click', function (e) {
  e.stopPropagation();
  document.querySelectorAll('.time-checkbox').forEach(function (cb) { cb.checked = false; });
  activeTimeRanges = [];
  applyCardFilters();
});

timeFilterApply.addEventListener('click', function (e) {
  e.stopPropagation();
  activeTimeRanges = Array.from(document.querySelectorAll('.time-checkbox:checked')).map(function (cb) { return cb.value; });
  applyCardFilters();
  timeFilterMenu.classList.remove('active');
});

stopsFilterReset.addEventListener('click', function (e) {
  e.stopPropagation();
  document.querySelectorAll('.stops-checkbox').forEach(function (cb) { cb.checked = false; });
  activeStops = [];
  applyCardFilters();
});

stopsFilterApply.addEventListener('click', function (e) {
  e.stopPropagation();
  activeStops = Array.from(document.querySelectorAll('.stops-checkbox:checked')).map(function (cb) { return cb.value; });
  applyCardFilters();
  stopsFilterMenu.classList.remove('active');
});

/* DYNAMIC DATE STRIP & SCROLL NAVIGATION LOGIC */
let stripAnchorDate = new Date(); // always anchors on the real current date
const dateCellsContainer = document.getElementById('dateCellsContainer');
const prevDateStripBtn = document.getElementById('prevDateStripBtn');
const nextDateStripBtn = document.getElementById('nextDateStripBtn');
const noFlightsMsg = document.getElementById('noFlightsMsg');

/* Simple deterministic string hash so each destination/country gets its own
   stable pseudo-random pattern for prices and flight availability. */
function hashString(str) {
  let hash = 0;
  const text = String(str || '');
  for (let i = 0; i < text.length; i++) {
    hash = (hash << 5) - hash + text.charCodeAt(i);
    hash |= 0;
  }
  return Math.abs(hash);
}

function getCurrentDestination() {
  return (destinationInput && destinationInput.value) ? destinationInput.value : 'Cebu';
}

function getCurrentOrigin() {
  return (originInput && originInput.value) ? originInput.value : 'Manila';
}

function getRouteSeed(date, destination, salt) {
  const dateSeed = date.getFullYear() * 10000 + (date.getMonth() + 1) * 100 + date.getDate();
  const destSeed = hashString(destination);
  return (dateSeed * 7 + destSeed * 13 + (salt || 0));
}

function pseudoFraction(seed) {
  const pseudo = Math.sin(seed) * 10000;
  return pseudo - Math.floor(pseudo);
}

/* Determines, per destination and date, whether flights are unavailable.
   Same destination + same date will always return the same result, but the
   pattern changes from country to country and day to day. */
function isNoFlightsDay(date, destination) {
  return pseudoFraction(getRouteSeed(date, destination, 91)) < 0.3;
}

/* Philippine domestic destinations - kept on the existing (lower) fare range.
   Anything not in this set is treated as an international route and gets a
   noticeably higher base fare below. */
const DOMESTIC_CITIES = new Set([
  'Bacolod', 'Bohol', 'Boracay', 'Butuan', 'Cagayan de Oro', 'Calbayog', 'Camiguin',
  'Cauayan', 'Cebu', 'Clark', 'Coron', 'Cotabato', 'Davao', 'Dipolog', 'Dumaguete',
  'El Nido', 'General Santos', 'Iloilo', 'Kalibo', 'Laoag', 'Legazpi', 'Manila',
  'Masbate', 'Naga', 'Ozamiz', 'Pagadian', 'Puerto Princesa', 'Roxas', 'San Jose',
  'San Vicente', 'Siargao', 'Surigao', 'Tacloban', 'Tawi-Tawi', 'Tuguegarao',
  'Virac', 'Zamboanga'
]);

function isDomesticCity(cityName) {
  if (!cityName) return true;
  const clean = cityName.split('(')[0].trim();
  return DOMESTIC_CITIES.has(clean);
}

/* Long-haul international destinations get their own (higher) fare range,
   separate from short/medium-haul international routes. */
const LONG_HAUL_CITIES = new Set(['Melbourne', 'Sydney', 'Dubai', 'Riyadh']);

function isLongHaulCity(cityName) {
  if (!cityName) return false;
  const clean = cityName.split('(')[0].trim();
  return LONG_HAUL_CITIES.has(clean);
}

/* Approximate scheduled block times Cebu Pacific publishes for these
   routes (in minutes), used as the baseline flight duration instead of
   a single random number applied to every flight on a given date. Keyed
   by destination city name since almost all of these routes are flown
   out of the Manila (MNL) hub; a distance-tier fallback below covers
   any destination not listed here. */
const CEBU_PACIFIC_ROUTE_DURATIONS = {
  'Cebu': 85, 'Davao': 100, 'Iloilo': 65, 'Bacolod': 70, 'Boracay': 75,
  'Puerto Princesa': 75, 'Coron': 70, 'Kalibo': 70, 'Bohol': 90,
  'Dumaguete': 85, 'Cagayan de Oro': 95, 'Zamboanga': 105,
  'General Santos': 110, 'Tacloban': 75, 'Legazpi': 55, 'Cauayan': 55,
  'Surigao': 90, 'Siargao': 95, 'Butuan': 90, 'Camiguin': 100,
  'Cotabato': 100, 'Dipolog': 95, 'Ozamiz': 95, 'Pagadian': 100,
  'Masbate': 60, 'Roxas': 55, 'Naga': 55, 'Calbayog': 70,
  'San Jose': 60, 'San Vicente': 75, 'Tuguegarao': 55, 'Virac': 65,
  'Tawi-Tawi': 130, 'Clark': 45,
  'HongKong': 120, 'Singapore': 210, 'Bangkok': 195, 'Chiang Mai': 220,
  'Seoul': 225, 'Osaka': 240, 'Nagoya': 240, 'Fukuoka': 210,
  'Sapporo': 270, 'Taipei': 130, 'Kaohsiung': 130, 'Bali': 240,
  'Jakarta': 210, 'Kuala Lumpur': 240, 'Macau': 120, 'Guangzhou': 130,
  'Shanghai': 150, 'Shenzhen': 140, 'Xiamen': 120,
  'Bandar Seri Begawan': 180, 'Da Nang': 150, 'Hanoi': 165,
  'Ho Chi Minh': 165,
  'Melbourne': 500, 'Sydney': 480, 'Dubai': 540, 'Riyadh': 570
};

function getBaseDurationMinutes(destination) {
  const clean = (destination || '').split('(')[0].trim();
  if (CEBU_PACIFIC_ROUTE_DURATIONS[clean] !== undefined) {
    return CEBU_PACIFIC_ROUTE_DURATIONS[clean];
  }
  if (CEBU_PACIFIC_ROUTE_DURATIONS[destination] !== undefined) {
    return CEBU_PACIFIC_ROUTE_DURATIONS[destination];
  }
  // Distance-tier fallback for any destination not in the table above,
  // reusing the same domestic/long-haul classification as pricing.
  if (isDomesticCity(destination)) return 80;
  if (isLongHaulCity(destination)) return 510;
  return 210;
}

/* Numeric "starts from" fare for a given date/destination, modeled after
   real-life Cebu Pacific all-in fares rather than base-fare-only promo
   pricing: domestic routes typically run ~PHP 3,500-8,500 all-in, short and
   medium-haul international routes (e.g. Hong Kong, Singapore, Bangkok,
   Tokyo-area, Seoul) run higher, and long-haul routes (Australia, Middle
   East) run higher still. Every destination/country keeps its own
   consistent range, and every date within that route gets its own
   variation on top of it. */
function getBasePriceValue(date, destination) {
  const variation = Math.floor(pseudoFraction(getRouteSeed(date, destination, 17)) * 1200);
  const destOffset = hashString(destination) % 2500;

  if (isDomesticCity(destination)) {
    return 3500 + Math.floor(destOffset * 2) + variation;
  }
  if (isLongHaulCity(destination)) {
    return 14000 + Math.floor(destOffset * 4.4) + Math.floor(variation * 3);
  }
  return 6000 + Math.floor(destOffset * 3.4) + Math.floor(variation * 2);
}

/* Same per-flight price sequence used by generateFlightCardsHTML (same
   base price + same seeded jitter per flight index), so the fare shown
   on a date-strip tab always matches the lowest "Starts from" price in
   the flight-card list rendered for that date. */
function getFlightPriceList(dateObj, destination) {
  const basePrice = getBasePriceValue(dateObj, destination);
  const flightCount = 4 + Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 53)) * 3);
  const prices = [];
  for (let i = 0; i < flightCount; i++) {
    const priceJitter = Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 210 + i)) * 900) + (i * 150);
    prices.push(basePrice + priceJitter);
  }
  return prices;
}

function getLowestFlightPrice(dateObj, destination) {
  const prices = getFlightPriceList(dateObj, destination);
  return Math.min(...prices);
}

function getPseudoRandomPrice(date, destination) {
  const lowestPrice = getLowestFlightPrice(date, destination);
  return `PHP ${lowestPrice.toLocaleString('en-US')}.00`;
}

/* Rough IATA-style code lookup for the cities used across the origin/
   destination pickers, with a safe fallback for anything not listed. */
const AIRPORT_CODES = {
  'Melbourne': 'MEL', 'Sydney': 'SYD', 'Guangzhou': 'CAN', 'Shanghai': 'PVG',
  'Shenzhen': 'SZX', 'Xiamen': 'XMN', 'Bandar Seri Begawan': 'BWN', 'HongKong': 'HKG',
  'Bali': 'DPS', 'Jakarta': 'CGK', 'Fukuoka': 'FUK', 'Nagoya': 'NGO',
  'Osaka': 'KIX', 'Sapporo': 'CTS', 'Macau': 'MFM', 'Kuala Lumpur': 'KUL',
  'Bacolod': 'BCD', 'Bohol': 'TAG', 'Boracay': 'MPH', 'Butuan': 'BXU',
  'Cagayan de Oro': 'CGY', 'Calbayog': 'CYP', 'Camiguin': 'CGM', 'Cauayan': 'CYZ',
  'Cebu': 'CEB', 'Clark': 'CRK', 'Coron': 'USU', 'Cotabato': 'CBO',
  'Davao': 'DVO', 'Dipolog': 'DPL', 'Dumaguete': 'DGT', 'El Nido': 'ENI',
  'General Santos': 'GES', 'Iloilo': 'ILO', 'Kalibo': 'KLO', 'Laoag': 'LAO',
  'Legazpi': 'LGP', 'Manila': 'MNL', 'Masbate': 'MBT', 'Naga': 'WNP',
  'Ozamiz': 'OZC', 'Pagadian': 'PAG', 'Puerto Princesa': 'PPS', 'Roxas': 'RXS',
  'San Jose': 'SJI', 'San Vicente': 'SWL', 'Siargao': 'IAO', 'Surigao': 'SUG',
  'Tacloban': 'TAC', 'Tawi-Tawi': 'TWT', 'Tuguegarao': 'TUG', 'Virac': 'VRC',
  'Zamboanga': 'ZAM', 'Riyadh': 'RUH', 'Singapore': 'SIN', 'Seoul': 'ICN',
  'Kaohsiung': 'KHH', 'Taipei': 'TPE', 'Bangkok': 'BKK', 'Chiang Mai': 'CNX',
  'Dubai': 'DXB', 'Da Nang': 'DAD', 'Hanoi': 'HAN', 'Ho Chi Minh': 'SGN'
};

function getAirportCode(cityName) {
  if (!cityName) return '';
  const clean = cityName.split('(')[0].trim();
  if (AIRPORT_CODES[clean]) return AIRPORT_CODES[clean];
  if (AIRPORT_CODES[cityName]) return AIRPORT_CODES[cityName];
  return clean.replace(/[^A-Za-z]/g, '').substring(0, 3).toUpperCase();
}

function formatTime24(totalMinutes) {
  const wrapped = ((totalMinutes % 1440) + 1440) % 1440;
  const h = Math.floor(wrapped / 60);
  const m = wrapped % 60;
  return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
}

/* AM/PM label for a given minutes-of-day value. The stored time strings
   (data-depart, etc.) stay in 24-hour "HH:MM" format everywhere so all the
   existing sorting/filtering logic keeps working unchanged — this is only
   used for the extra label shown next to the time in the UI. */
function getPeriodLabel(totalMinutes) {
  const wrapped = ((totalMinutes % 1440) + 1440) % 1440;
  return Math.floor(wrapped / 60) < 12 ? 'AM' : 'PM';
}

function formatDateISO(dateObj) {
  const year = dateObj.getFullYear();
  const month = String(dateObj.getMonth() + 1).padStart(2, '0');
  const day = String(dateObj.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

/* Builds a randomized (but deterministic per date + destination) set of
   flight-card listings so that whenever the user picks a date that has
   flights, the results below actually reflect that date's fare. */
function generateFlightCardsHTML(dateObj, destination) {
  const origin = getCurrentOrigin();
  const originCode = getAirportCode(origin);
  const destCode = getAirportCode(destination);
  const dateStr = formatDateISO(dateObj);

  const basePrice = getBasePriceValue(dateObj, destination);
  const flightCount = 4 + Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 53)) * 3);
  const baseDurationMinutes = getBaseDurationMinutes(destination);
  const airlines = ['5J', 'DG'];

  let minutesCursor = 240; // first departure around 04:00
  let cardsHtml = '';

  for (let i = 0; i < flightCount; i++) {
    if (i > 0) {
      const gapMinutes = 70 + Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 130 + i)) * 140);
      minutesCursor += gapMinutes;
    }

    /* Each flight's duration varies a little around the route's real
       Cebu Pacific baseline (traffic, routing, headwinds, etc.) instead
       of every flight on the day sharing one identical duration. */
    const durationJitter = Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 300 + i)) * 21) - 10;
    const durationMinutes = Math.max(30, baseDurationMinutes + durationJitter);
    const durationLabel = `${Math.floor(durationMinutes / 60)}h ${durationMinutes % 60}m`;

    const depMinutes = minutesCursor;
    const arrMinutes = depMinutes + durationMinutes;
    const depTime = formatTime24(depMinutes);
    const arrTime = formatTime24(arrMinutes);
    const depPeriod = getPeriodLabel(depMinutes);
    const arrPeriod = getPeriodLabel(arrMinutes);

    const flightAirline = airlines[i % airlines.length];
    const flightNum = 500 + Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 170 + i)) * 500);
    const priceJitter = Math.floor(pseudoFraction(getRouteSeed(dateObj, destination, 210 + i)) * 900) + (i * 150);
    const flightPrice = basePrice + priceJitter;

    cardsHtml += `
      <div class="flight-card" data-price="${flightPrice}" data-depart="${depTime}" data-duration="${durationMinutes}" data-date="${dateStr}">
        <div class="flight-left">
          <div class="flight-times">
            <div class="time-group">
              <span class="time">${depTime}</span><span class="period">${depPeriod}</span>
              <span class="city">${originCode}</span>
            </div>
            <span class="arrow-sep">&#10140;</span>
            <div class="time-group">
              <span class="time">${arrTime}</span><span class="period">${arrPeriod}</span>
              <span class="city">${destCode}</span>
            </div>
          </div>
          <div class="flight-meta">
            <span class="flight-num">${flightAirline} ${flightNum}</span>
            <span class="direct-badge">Direct</span>
            <span class="duration">${durationLabel}</span>
          </div>
        </div>
        <div class="flight-right">
          <span class="price-label">Starts from</span>
          <div class="price-amount"><span class="currency">PHP</span>${flightPrice.toLocaleString('en-US')}.00</div>
          <button class="select-btn">Select</button>
        </div>
      </div>`;
  }

  return cardsHtml;
}

function filterFlightsByDate(dateObj) {
  const destination = getCurrentDestination();
  const forcedNoFlights = isNoFlightsDay(dateObj, destination);

  /* Picking a different date invalidates whatever flight was chosen for
     the previous date, so clear that selection and unlock this section's
     date-strip/filter controls before showing the new date's cards
     (inserted - keeps the locked state from carrying over inconsistently). */
  selectedFlightCard = null;
  setSectionControlsLocked(flightsContainer, false);

  if (forcedNoFlights) {
    flightsContainer.innerHTML = '';
    noFlightsMsg.style.display = 'flex';
  } else {
    flightsContainer.innerHTML = generateFlightCardsHTML(dateObj, destination);
    noFlightsMsg.style.display = 'none';
    applyCardFilters();
  }

  updateContinueState();
}

function renderDateStrip() {
  dateCellsContainer.innerHTML = '';
  const daysShort = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const monthsShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  for (let i = -2; i <= 2; i++) {
    const cellDate = new Date(stripAnchorDate);
    cellDate.setDate(stripAnchorDate.getDate() + i);
    cellDate.setHours(0, 0, 0, 0);

    const cellDiv = document.createElement('div');
    cellDiv.classList.add('date-cell');

    const isPastDate = cellDate < today;

    if (startDate && cellDate.toDateString() === startDate.toDateString()) {
      cellDiv.classList.add('active');
    }

    const dayName = daysShort[cellDate.getDay()];
    const dayNum = String(cellDate.getDate()).padStart(2, '0');
    const monthName = monthsShort[cellDate.getMonth()];

    const destination = getCurrentDestination();
    const cellHasNoFlights = isNoFlightsDay(cellDate, destination);
    const priceText = cellHasNoFlights ? 'No Flights' : getPseudoRandomPrice(cellDate, destination);
    const priceClass = cellHasNoFlights ? 'date-price no-flights-label' : 'date-price';

    if (cellHasNoFlights) {
      cellDiv.classList.add('no-flights');
    }

    if (isPastDate) {
      cellDiv.classList.add('past-date');
    }

    cellDiv.innerHTML = `
      <div class="date-day">${dayName}, ${dayNum} ${monthName}</div>
      <div class="${priceClass}">${priceText}</div>
    `;

    if (!isPastDate) {
      cellDiv.addEventListener('click', function (e) {
        e.stopPropagation();
        startDate = new Date(cellDate);
        stripAnchorDate = new Date(cellDate);
        departInput.value = formatDate(startDate);
        renderDateStrip();
        filterFlightsByDate(startDate);
        if (departInput.value) {
          if (returnInput.value) {
            summaryDatesText.innerText = `${departInput.value} - ${returnInput.value}`;
          } else {
            summaryDatesText.innerText = departInput.value;
          }
        }
        /* Departing date just changed — re-render the returning-flight
           date strip so dates before the new departing date get locked
           (or unlocked) right away, if that section is currently shown. */
        if (returnFlightPage && returnFlightPage.style.display !== 'none') {
          renderReturnDateStrip();
        }
      });
    }

    dateCellsContainer.appendChild(cellDiv);
  }

  // Don't allow scrolling the strip further back than today
  const leftMostDate = new Date(stripAnchorDate);
  leftMostDate.setDate(stripAnchorDate.getDate() - 2);
  leftMostDate.setHours(0, 0, 0, 0);
  if (leftMostDate <= today) {
    prevDateStripBtn.classList.add('disabled');
  } else {
    prevDateStripBtn.classList.remove('disabled');
  }
}

prevDateStripBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  const candidate = new Date(stripAnchorDate);
  candidate.setDate(candidate.getDate() - 1);
  const newLeftMost = new Date(candidate);
  newLeftMost.setDate(newLeftMost.getDate() - 2);
  newLeftMost.setHours(0, 0, 0, 0);
  if (newLeftMost < today) {
    return;
  }
  stripAnchorDate = candidate;
  renderDateStrip();
});

nextDateStripBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  stripAnchorDate.setDate(stripAnchorDate.getDate() + 1);
  renderDateStrip();
});

/* SORTING LOGIC */
const sortBtn = document.getElementById('sortBtn');
const sortMenu = document.getElementById('sortMenu');
const flightsContainer = document.getElementById('flightsContainer');

sortBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  sortMenu.classList.toggle('active');
});

const sortOptions = document.querySelectorAll('.sort-option');
sortOptions.forEach(option => {
  option.addEventListener('click', function (e) {
    e.stopPropagation();
    const sortType = this.getAttribute('data-sort');
    sortMenu.classList.remove('active');

    const cardsArray = Array.from(flightsContainer.querySelectorAll('.flight-card'));

    cardsArray.sort((a, b) => {
      if (sortType === 'price') {
        return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
      } else if (sortType === 'depart') {
        return a.getAttribute('data-depart').localeCompare(b.getAttribute('data-depart'));
      } else if (sortType === 'duration') {
        return parseInt(a.getAttribute('data-duration')) - parseInt(b.getAttribute('data-duration'));
      }
    });

    cardsArray.forEach(card => flightsContainer.appendChild(card));
  });
});

/* ================= RETURNING FLIGHT SECTION (inserted) =================
   Mirrors the departing-flight logic above (date strip, filters, sort,
   card generation) for the return leg, reusing the same price/duration
   helper functions (getBasePriceValue, getBaseDurationMinutes,
   isNoFlightsDay, getPseudoRandomPrice) so the return date-strip fares
   stay consistent with the return flight-card list, exactly like the
   departing section. Only shown for round-trip searches with a return
   date selected. */

const returnFlightPage = document.getElementById('returnFlightPage');
const retRouteCities = document.getElementById('retRouteCities');
const retDateCellsContainer = document.getElementById('retDateCellsContainer');
const retPrevDateStripBtn = document.getElementById('retPrevDateStripBtn');
const retNextDateStripBtn = document.getElementById('retNextDateStripBtn');
const retNoFlightsMsg = document.getElementById('retNoFlightsMsg');
const retFlightsContainer = document.getElementById('retFlightsContainer');

const retTimeFilterBtn = document.getElementById('retTimeFilterBtn');
const retTimeFilterMenu = document.getElementById('retTimeFilterMenu');
const retDepartureTab = document.getElementById('retDepartureTab');
const retArrivalTab = document.getElementById('retArrivalTab');
const retTimeFilterReset = document.getElementById('retTimeFilterReset');
const retTimeFilterApply = document.getElementById('retTimeFilterApply');
const retStopsFilterBtn = document.getElementById('retStopsFilterBtn');
const retStopsFilterMenu = document.getElementById('retStopsFilterMenu');
const retStopsFilterReset = document.getElementById('retStopsFilterReset');
const retStopsFilterApply = document.getElementById('retStopsFilterApply');
const retSortBtn = document.getElementById('retSortBtn');
const retSortMenu = document.getElementById('retSortMenu');

let retStripAnchorDate = new Date(); // always anchors on the real current date
let retStartDate = null;
let retTimeFilterMode = 'departure';
let retActiveTimeRanges = [];
let retActiveStops = [];

// Clicks inside these menus shouldn't bubble to the document-level
// "click outside closes menus" handler (same fix as the departing menus).
retTimeFilterMenu.addEventListener('click', function (e) { e.stopPropagation(); });
retStopsFilterMenu.addEventListener('click', function (e) { e.stopPropagation(); });

function getReturnCardArrivalTimeStr(card) {
  const times = card.querySelectorAll('.time-group .time');
  return times.length > 1 ? times[1].innerText : card.getAttribute('data-depart');
}

function passesReturnTimeFilter(card) {
  if (retActiveTimeRanges.length === 0) return true;
  const timeStr = retTimeFilterMode === 'arrival' ? getReturnCardArrivalTimeStr(card) : card.getAttribute('data-depart');
  const minutes = getMinutesFromTimeStr(timeStr) % 1440;
  return retActiveTimeRanges.some(function (range) {
    const bounds = range.split('-').map(Number);
    return minutes >= bounds[0] && minutes <= bounds[1];
  });
}

function passesReturnStopsFilter(card) {
  if (retActiveStops.length === 0) return true;
  const badge = card.querySelector('.direct-badge');
  const stopsLabel = badge ? badge.innerText.trim() : 'Direct';
  return retActiveStops.indexOf(stopsLabel) !== -1;
}

/* When the return date lands on the exact same day as the already-selected
   departing flight, a returning flight also has to leave strictly later
   than the departing flight's own departure time — same time (or earlier)
   isn't a valid return. On any other day this always passes. */
function passesReturnSameDayTimeCutoff(card) {
  if (!selectedFlightCard || !retStartDate || !startDate) return true;
  if (retStartDate.toDateString() !== startDate.toDateString()) return true;
  const departingMinutes = getMinutesFromTimeStr(selectedFlightCard.getAttribute('data-depart'));
  const cardMinutes = getMinutesFromTimeStr(card.getAttribute('data-depart'));
  return cardMinutes > departingMinutes;
}

function applyReturnCardFilters() {
  const cards = retFlightsContainer.querySelectorAll('.flight-card');
  cards.forEach(function (card) {
    const passes = passesReturnTimeFilter(card) && passesReturnStopsFilter(card) && passesReturnSameDayTimeCutoff(card);
    card.style.display = passes ? 'flex' : 'none';
  });
}

/* Called whenever the departing flight selection changes. Re-applies the
   same-day time cutoff to the currently listed return cards, and if the
   already-picked return flight no longer qualifies (it's now the same
   time as, or earlier than, the newly picked departing flight), clears
   that return selection instead of leaving an invalid one in place. */
function refreshReturnSameDayFilter() {
  if (!retFlightsContainer.querySelector('.flight-card')) return;
  if (selectedReturnFlightCard && !passesReturnSameDayTimeCutoff(selectedReturnFlightCard)) {
    selectedReturnFlightCard.classList.remove('flight-card-selected');
    selectedReturnFlightCard = null;
    expandAllCards(retFlightsContainer);
  } else {
    applyReturnCardFilters();
  }
  updateContinueState();
}

/* Same algorithm as generateFlightCardsHTML, but with origin/destination
   swapped for display (return leg flies back to the original origin),
   while still using the outbound destination as the fare/duration
   lookup key so the return fares stay in the same realistic route range. */
function generateReturnFlightCardsHTML(dateObj) {
  const routeKey = getCurrentDestination();
  const originCode = getAirportCode(getCurrentDestination());
  const destCode = getAirportCode(getCurrentOrigin());
  const dateStr = formatDateISO(dateObj);

  const basePrice = getBasePriceValue(dateObj, routeKey);
  const flightCount = 4 + Math.floor(pseudoFraction(getRouteSeed(dateObj, routeKey, 53)) * 3);
  const baseDurationMinutes = getBaseDurationMinutes(routeKey);
  const airlines = ['5J', 'DG'];

  let minutesCursor = 240;
  let cardsHtml = '';

  for (let i = 0; i < flightCount; i++) {
    if (i > 0) {
      const gapMinutes = 70 + Math.floor(pseudoFraction(getRouteSeed(dateObj, routeKey, 130 + i)) * 140);
      minutesCursor += gapMinutes;
    }

    const durationJitter = Math.floor(pseudoFraction(getRouteSeed(dateObj, routeKey, 300 + i)) * 21) - 10;
    const durationMinutes = Math.max(30, baseDurationMinutes + durationJitter);
    const durationLabel = `${Math.floor(durationMinutes / 60)}h ${durationMinutes % 60}m`;

    const depMinutes = minutesCursor;
    const arrMinutes = depMinutes + durationMinutes;
    const depTime = formatTime24(depMinutes);
    const arrTime = formatTime24(arrMinutes);
    const depPeriod = getPeriodLabel(depMinutes);
    const arrPeriod = getPeriodLabel(arrMinutes);

    const flightAirline = airlines[i % airlines.length];
    const flightNum = 500 + Math.floor(pseudoFraction(getRouteSeed(dateObj, routeKey, 170 + i)) * 500);
    const priceJitter = Math.floor(pseudoFraction(getRouteSeed(dateObj, routeKey, 210 + i)) * 900) + (i * 150);
    const flightPrice = basePrice + priceJitter;

    cardsHtml += `
      <div class="flight-card" data-price="${flightPrice}" data-depart="${depTime}" data-duration="${durationMinutes}" data-date="${dateStr}">
        <div class="flight-left">
          <div class="flight-times">
            <div class="time-group">
              <span class="time">${depTime}</span><span class="period">${depPeriod}</span>
              <span class="city">${originCode}</span>
            </div>
            <span class="arrow-sep">&#10140;</span>
            <div class="time-group">
              <span class="time">${arrTime}</span><span class="period">${arrPeriod}</span>
              <span class="city">${destCode}</span>
            </div>
          </div>
          <div class="flight-meta">
            <span class="flight-num">${flightAirline} ${flightNum}</span>
            <span class="direct-badge">Direct</span>
            <span class="duration">${durationLabel}</span>
          </div>
        </div>
        <div class="flight-right">
          <span class="price-label">Starts from</span>
          <div class="price-amount"><span class="currency">PHP</span>${flightPrice.toLocaleString('en-US')}.00</div>
          <button class="select-btn">Select</button>
        </div>
      </div>`;
  }

  return cardsHtml;
}

function filterReturnFlightsByDate(dateObj) {
  const routeKey = getCurrentDestination();
  const forcedNoFlights = isNoFlightsDay(dateObj, routeKey);

  /* Same fix as filterFlightsByDate: clear the previous return-flight
     selection and unlock this section's controls before showing the
     new date's cards (inserted). */
  selectedReturnFlightCard = null;
  setSectionControlsLocked(retFlightsContainer, false);

  if (forcedNoFlights) {
    retFlightsContainer.innerHTML = '';
    retNoFlightsMsg.style.display = 'flex';
  } else {
    retFlightsContainer.innerHTML = generateReturnFlightCardsHTML(dateObj);
    retNoFlightsMsg.style.display = 'none';
    applyReturnCardFilters();
  }

  updateContinueState();
}

function renderReturnDateStrip() {
  retDateCellsContainer.innerHTML = '';
  const daysShort = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const monthsShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  for (let i = -2; i <= 2; i++) {
    const cellDate = new Date(retStripAnchorDate);
    cellDate.setDate(retStripAnchorDate.getDate() + i);
    cellDate.setHours(0, 0, 0, 0);

    const cellDiv = document.createElement('div');
    cellDiv.classList.add('date-cell');

    /* A returning-flight date can never be earlier than today NOR earlier
       than the already-selected departing flight date. Since a selected
       startDate is itself always >= today, using it (when present) as the
       floor for "past" automatically also locks out any date before the
       chosen departing flight. */
    const minAllowedDate = startDate || today;
    const isPastDate = cellDate < minAllowedDate;

    if (retStartDate && cellDate.toDateString() === retStartDate.toDateString()) {
      cellDiv.classList.add('active');
    }

    const dayName = daysShort[cellDate.getDay()];
    const dayNum = String(cellDate.getDate()).padStart(2, '0');
    const monthName = monthsShort[cellDate.getMonth()];

    const routeKey = getCurrentDestination();
    const cellHasNoFlights = isNoFlightsDay(cellDate, routeKey);
    const priceText = cellHasNoFlights ? 'No Flights' : getPseudoRandomPrice(cellDate, routeKey);
    const priceClass = cellHasNoFlights ? 'date-price no-flights-label' : 'date-price';

    if (cellHasNoFlights) {
      cellDiv.classList.add('no-flights');
    }
    if (isPastDate) {
      cellDiv.classList.add('past-date');
    }

    cellDiv.innerHTML = `
      <div class="date-day">${dayName}, ${dayNum} ${monthName}</div>
      <div class="${priceClass}">${priceText}</div>
    `;

    if (!isPastDate) {
      cellDiv.addEventListener('click', function (e) {
        e.stopPropagation();
        retStartDate = new Date(cellDate);
        retStripAnchorDate = new Date(cellDate);
        returnInput.value = formatDate(retStartDate);
        endDate = new Date(retStartDate);
        renderReturnDateStrip();
        filterReturnFlightsByDate(retStartDate);
        if (departInput.value) {
          summaryDatesText.innerText = `${departInput.value} - ${returnInput.value}`;
        }
      });
    }

    retDateCellsContainer.appendChild(cellDiv);
  }

  const leftMostDate = new Date(retStripAnchorDate);
  leftMostDate.setDate(retStripAnchorDate.getDate() - 2);
  leftMostDate.setHours(0, 0, 0, 0);
  if (leftMostDate < today) {
    retPrevDateStripBtn.classList.add('disabled');
  } else {
    retPrevDateStripBtn.classList.remove('disabled');
  }
}

retPrevDateStripBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  const candidate = new Date(retStripAnchorDate);
  candidate.setDate(candidate.getDate() - 1);
  const newLeftMost = new Date(candidate);
  newLeftMost.setDate(newLeftMost.getDate() - 2);
  newLeftMost.setHours(0, 0, 0, 0);
  if (newLeftMost < today) {
    return;
  }
  retStripAnchorDate = candidate;
  renderReturnDateStrip();
});

retNextDateStripBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  retStripAnchorDate.setDate(retStripAnchorDate.getDate() + 1);
  renderReturnDateStrip();
});

retTimeFilterBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  retStopsFilterMenu.classList.remove('active');
  retSortMenu.classList.remove('active');
  retTimeFilterMenu.classList.toggle('active');
});

retStopsFilterBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  retTimeFilterMenu.classList.remove('active');
  retSortMenu.classList.remove('active');
  retStopsFilterMenu.classList.toggle('active');
});

retDepartureTab.addEventListener('click', function (e) {
  e.stopPropagation();
  retTimeFilterMode = 'departure';
  retDepartureTab.classList.add('active');
  retArrivalTab.classList.remove('active');
});

retArrivalTab.addEventListener('click', function (e) {
  e.stopPropagation();
  retTimeFilterMode = 'arrival';
  retArrivalTab.classList.add('active');
  retDepartureTab.classList.remove('active');
});

retTimeFilterReset.addEventListener('click', function (e) {
  e.stopPropagation();
  document.querySelectorAll('.ret-time-checkbox').forEach(function (cb) { cb.checked = false; });
  retActiveTimeRanges = [];
  applyReturnCardFilters();
});

retTimeFilterApply.addEventListener('click', function (e) {
  e.stopPropagation();
  retActiveTimeRanges = Array.from(document.querySelectorAll('.ret-time-checkbox:checked')).map(function (cb) { return cb.value; });
  applyReturnCardFilters();
  retTimeFilterMenu.classList.remove('active');
});

retStopsFilterReset.addEventListener('click', function (e) {
  e.stopPropagation();
  document.querySelectorAll('.ret-stops-checkbox').forEach(function (cb) { cb.checked = false; });
  retActiveStops = [];
  applyReturnCardFilters();
});

retStopsFilterApply.addEventListener('click', function (e) {
  e.stopPropagation();
  retActiveStops = Array.from(document.querySelectorAll('.ret-stops-checkbox:checked')).map(function (cb) { return cb.value; });
  applyReturnCardFilters();
  retStopsFilterMenu.classList.remove('active');
});

retSortBtn.addEventListener('click', function (e) {
  e.stopPropagation();
  retSortMenu.classList.toggle('active');
});

const retSortOptions = retSortMenu.querySelectorAll('.sort-option');
retSortOptions.forEach(option => {
  option.addEventListener('click', function (e) {
    e.stopPropagation();
    const sortType = this.getAttribute('data-sort');
    retSortMenu.classList.remove('active');

    const cardsArray = Array.from(retFlightsContainer.querySelectorAll('.flight-card'));

    cardsArray.sort((a, b) => {
      if (sortType === 'price') {
        return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
      } else if (sortType === 'depart') {
        return a.getAttribute('data-depart').localeCompare(b.getAttribute('data-depart'));
      } else if (sortType === 'duration') {
        return parseInt(a.getAttribute('data-duration')) - parseInt(b.getAttribute('data-duration'));
      }
    });

    cardsArray.forEach(card => retFlightsContainer.appendChild(card));
  });
});

/* Shows/builds the returning-flight section for round-trip searches
   with a return date chosen; hides it otherwise (one-way searches). */
function updateReturnSectionVisibility() {
  const isRoundTrip = tripTypeBtn.innerText === 'Round-trip';
  if (isRoundTrip && endDate) {
    returnFlightPage.style.display = '';
    retStartDate = new Date(endDate);
    retStripAnchorDate = new Date(endDate);
    retRouteCities.innerText = `${getCurrentDestination()} to ${getCurrentOrigin()}`;
    renderReturnDateStrip();
    filterReturnFlightsByDate(retStartDate);
  } else {
    returnFlightPage.style.display = 'none';
  }
  updateContinueState();
}

/* CONTINUE BAR LOGIC (inserted; updated to account for the return leg) */
const continueBtn = document.getElementById('continueBtn');
const continueHint = document.getElementById('continueHint');
let selectedFlightCard = null;
let selectedReturnFlightCard = null;

function updateContinueState() {
  const isRoundTrip = returnFlightPage.style.display !== 'none';
  const departOk = !!selectedFlightCard;
  const returnOk = !isRoundTrip || !!selectedReturnFlightCard;

  continueBtn.disabled = !(departOk && returnOk);

  if (!departOk) {
    continueHint.innerText = 'Select a flight to continue';
  } else if (isRoundTrip && !returnOk) {
    continueHint.innerText = 'Select your returning flight to continue';
  } else {
    const departPrice = selectedFlightCard.querySelector('.price-amount') ? selectedFlightCard.querySelector('.price-amount').innerText : '';
    if (isRoundTrip) {
      const returnPrice = selectedReturnFlightCard.querySelector('.price-amount') ? selectedReturnFlightCard.querySelector('.price-amount').innerText : '';
      const totalAmount = parsePriceAmount(departPrice) + parsePriceAmount(returnPrice);
      continueHint.innerText = `Flights selected - Total: ${formatPriceAmount(totalAmount)}`;
    } else {
      const totalAmount = parsePriceAmount(departPrice);
      continueHint.innerText = `Flight selected${departPrice ? ' - Total: ' + formatPriceAmount(totalAmount) : ''}`;
    }
  }
}

/* Helpers for computing the combined total (inserted) */
function parsePriceAmount(text) {
  if (!text) return 0;
  const numeric = text.replace(/[^0-9.]/g, '');
  return parseFloat(numeric) || 0;
}

function formatPriceAmount(amount) {
  return 'PHP' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

/* ---------- COLLAPSE / EXPAND ON SELECT (inserted) ----------
   When a flight is selected, every other card in that section is hidden
   and the chosen card's "Select" button turns into a "Change" button with
   a small checkmark badge. Clicking "Change" restores all the choices. */
function collapseOtherCards(container, card) {
  container.querySelectorAll('.flight-card').forEach(function (c) {
    if (c !== card) {
      c.classList.add('fc-hidden');
      c.style.display = 'none';
    }
  });

  const btn = card.querySelector('.select-btn');
  if (btn) {
    btn.textContent = 'Change';
    btn.classList.add('change-btn');
  }

  if (!card.querySelector('.selected-check-badge')) {
    const badge = document.createElement('div');
    badge.className = 'selected-check-badge';
    badge.innerHTML = '&#10003;';
    card.appendChild(badge);
  }

  setSectionControlsLocked(container, true);
}

/* Locks (or unlocks) the date strip and filter/sort bar for whichever
   section (departing or returning) the given flight cards container
   belongs to, so a chosen flight can't be second-guessed by browsing
   other dates or re-filtering until "Change" is clicked (inserted). */
function setSectionControlsLocked(container, locked) {
  const page = container.closest('.page');
  if (!page) return;

  const dateStrip = page.querySelector('.date-strip');
  const filterRow = page.querySelector('.filter-row');

  [dateStrip, filterRow].forEach(function (el) {
    if (!el) return;
    if (locked) {
      el.classList.add('controls-locked');
    } else {
      el.classList.remove('controls-locked');
    }
  });

  if (locked) {
    page.querySelectorAll('.time-filter-menu.active, .stops-filter-menu.active, .sort-menu.active').forEach(function (menu) {
      menu.classList.remove('active');
    });
  }
}

function expandAllCards(container) {
  container.querySelectorAll('.flight-card').forEach(function (c) {
    c.classList.remove('fc-hidden');
    c.style.display = '';
  });

  container.querySelectorAll('.select-btn.change-btn').forEach(function (btn) {
    btn.textContent = 'Select';
    btn.classList.remove('change-btn');
  });

  container.querySelectorAll('.selected-check-badge').forEach(function (badge) {
    badge.remove();
  });

  setSectionControlsLocked(container, false);

  if (container === flightsContainer) {
    applyCardFilters();
  } else if (container === retFlightsContainer) {
    applyReturnCardFilters();
  }
}

flightsContainer.addEventListener('click', function (e) {
  const clickedSelectBtn = e.target.closest('.select-btn');
  if (!clickedSelectBtn) return;

  const card = clickedSelectBtn.closest('.flight-card');
  if (!card) return;

  if (clickedSelectBtn.classList.contains('change-btn')) {
    expandAllCards(flightsContainer);
    if (selectedFlightCard) {
      selectedFlightCard.classList.remove('flight-card-selected');
    }
    selectedFlightCard = null;
    refreshReturnSameDayFilter();
    updateContinueState();
    return;
  }

  if (selectedFlightCard) {
    selectedFlightCard.classList.remove('flight-card-selected');
  }
  selectedFlightCard = card;
  selectedFlightCard.classList.add('flight-card-selected');
  collapseOtherCards(flightsContainer, card);

  refreshReturnSameDayFilter();
  updateContinueState();
});

retFlightsContainer.addEventListener('click', function (e) {
  const clickedSelectBtn = e.target.closest('.select-btn');
  if (!clickedSelectBtn) return;

  const card = clickedSelectBtn.closest('.flight-card');
  if (!card) return;

  if (clickedSelectBtn.classList.contains('change-btn')) {
    expandAllCards(retFlightsContainer);
    if (selectedReturnFlightCard) {
      selectedReturnFlightCard.classList.remove('flight-card-selected');
    }
    selectedReturnFlightCard = null;
    updateContinueState();
    return;
  }

  if (selectedReturnFlightCard) {
    selectedReturnFlightCard.classList.remove('flight-card-selected');
  }
  selectedReturnFlightCard = card;
  selectedReturnFlightCard.classList.add('flight-card-selected');
  collapseOtherCards(retFlightsContainer, card);

  updateContinueState();
});

// Philippine domestic points (the "Philippines" country group in the
// Origin/Destination modals). Used to decide whether a chosen route is
// local-to-local (domestic) or local-to-international.
const PH_LOCAL_CITIES = ["Bacolod","Bohol","Boracay (Caticlan)","Butuan","Cagayan de Oro","Calbayog","Camiguin","Cauayan","Cebu","Clark","Coron (Busuanga)","Cotabato","Davao","Dipolog","Dumaguete","El Nido","General Santos","Iloilo","Kalibo","Laoag","Legazpi (Daraga)","Manila","Masbate","Naga","Ozamiz","Pagadian","Puerto Princesa","Roxas","San Jose (Mindoro)","San Vicente (Port Barton)","Siargao","Surigao","Tacloban","Tawi-Tawi","Tuguegarao","Virac","Zamboanga"];

function isPhLocalCity(cityName) {
  return PH_LOCAL_CITIES.indexOf((cityName || '').trim()) !== -1;
}

continueBtn.addEventListener('click', function () {
  if (continueBtn.disabled) return;
  
  // Proceed to the next step in the booking flow (Guest Details)
  selectView.classList.remove('active-view');

  // Build the actual selected route text, e.g., "Manila (MNL) ✈ Melbourne (MEL)"
  const originName = (originInput.value || '').split('(')[0].trim();
  const destinationName = (destinationInput.value || '').split('(')[0].trim();
  const originCode = getAirportCode(originInput.value);
  const destinationCode = getAirportCode(destinationInput.value);
  const routeText = (originName && destinationName)
    ? originName + ' (' + originCode + ') \u2708 ' + destinationName + ' (' + destinationCode + ')'
    : '';

  // Route ALL flights (Domestic & International) to your main Guest Details form
  if (routeText) {
    const routeEl = document.querySelector('#guestView .bundle-route');
    if (routeEl) routeEl.textContent = routeText;
  }
  
  document.getElementById('guestView').classList.add('active-view');
  window.scrollTo(0, 0);
});

// Reads every guest/contact field on THIS page (the domestic Guest Details
// form) into a plain object. Mirrors the identical helper duplicated inside
// the international guest form's iframe (that copy runs in the iframe's own
// document and hands its result to us via postMessage instead).
function collectGuestInfoFromDoc(doc) {
  function val(id) { const el = doc.getElementById(id); return el ? el.value.trim() : ''; }
  function selectVal(id) { const el = doc.getElementById(id); if (!el) return ''; return el.selectedIndex > 0 ? el.value : ''; }
  function isChecked(id) { const el = doc.getElementById(id); return !!(el && el.checked); }

  const title = selectVal('title');
  const firstName = val('firstName');
  const lastName = val('lastName');
  const fullName = [title, firstName, lastName].filter(Boolean).join(' ');

  const day = val('dayInput'), month = val('monthInput'), year = val('yearInput');
  const dob = [day, month, year].filter(Boolean).join(' ');

  const nationality = selectVal('nationalitySelect');

  const goRewardsEl = doc.querySelector('input[placeholder="e.g. 4041178445"]');
  const goRewardsId = goRewardsEl ? goRewardsEl.value.trim() : '';

  const passportNumber = val('passportNumber');
  const passportCountry = selectVal('passportCountry');
  const passExpDay = val('passExpDayInput'), passExpMonth = val('passExpMonthInput'), passExpYear = val('passExpYearInput');
  const passportExpiry = [passExpDay, passExpMonth, passExpYear].filter(Boolean).join(' ');

  const useGuestToggleEl = doc.getElementById('useGuestToggle');
  const useGuestDetails = useGuestToggleEl ? useGuestToggleEl.checked : true;
  let contactName;
  if (useGuestDetails) {
    contactName = fullName;
  } else {
    const cTitle = selectVal('contactTitle');
    const cFirst = val('contactFirstName');
    const cLast = val('contactLastName');
    contactName = [cTitle, cFirst, cLast].filter(Boolean).join(' ');
  }

  const countryCodeEl = doc.getElementById('countryCodeInput');
  const countryCode = countryCodeEl ? countryCodeEl.value.trim() : '';
  const mobileNumber = val('mobileInput');
  const email = val('contactEmail');

  return {
    title, firstName, lastName, fullName,
    dob, nationality, goRewardsId,
    passportNumber, passportCountry, passportExpiry,
    contactName, countryCode, mobileNumber, email
  };
}

// Sets a readable column width on a worksheet based on its longest cell/header,
// so numbers and text aren't clipped when the file is opened in Excel/Sheets.
function autosizeColumns(ws, rows) {
  if (!rows || !rows.length) return;
  const headers = Object.keys(rows[0]);
  ws['!cols'] = headers.map(h => {
    let maxLen = String(h).length;
    rows.forEach(r => {
      const v = (r[h] === undefined || r[h] === null) ? '' : String(r[h]);
      if (v.length > maxLen) maxLen = v.length;
    });
    return { wch: Math.min(Math.max(maxLen + 2, 10), 60) };
  });
}

// Fixed column order for each sheet, matching the order fields are actually
// collected in the guest form (name -> DOB -> nationality -> passport ->
// contact -> flight details). Rows are always normalized to this exact key
// order before being written, so appending a new booking to an existing
// file never pushes a column to the end just because an older row didn't
// have it yet (a plain object union would do that).
const BOOKING_HEADERS = [
  'Guest Name', 'Date of Birth', 'Nationality', 'Passport Number', 'Contact Number', 'Email',
  'Origin', 'Origin Code', 'Destination', 'Destination Code', 'Trip Type',
  'Departure Date', 'Departure Time', 'Arrival Time', 'Outbound Flight No.', 'Outbound Price (PHP)',
  'Return Date', 'Return Departure Time', 'Return Arrival Time', 'Return Flight No.', 'Return Price (PHP)',
  'Total Price (PHP)', 'Booked On'
];
const GUEST_HEADERS = [
  'Full Name', 'Title', 'First Name', 'Last Name', 'Date of Birth', 'Nationality',
  'GO Rewards Membership ID', 'Passport Number', 'Passport Country of Issue', 'Passport Expiration Date',
  'OEC/MEC Number', 'PWD ID Number'
];
const CONTACT_HEADERS = ['Contact Name', 'Country Code', 'Mobile Number', 'Email'];

// Rebuilds a row with exactly the given keys, in that order (missing values
// become ''), so every row - whether freshly built or read back from an
// older file - lines up under the same fixed columns.
function normalizeRow(row, headers) {
  const out = {};
  headers.forEach(h => { out[h] = (row && row[h] !== undefined && row[h] !== null) ? row[h] : ''; });
  return out;
}
function normalizeRows(rows, headers) {
  return (rows || []).map(r => normalizeRow(r, headers));
}

// Lazily loads sql.js (WebAssembly SQLite) once and reuses the same init
// promise for every export, so we don't re-download the .wasm file each time.
let _sqlJsPromise = null;
function getSqlJs() {
  if (!_sqlJsPromise) {
    if (typeof initSqlJs === 'undefined') {
      console.warn('sql.js not loaded; skipping SQLite export.');
      return Promise.resolve(null);
    }
    _sqlJsPromise = initSqlJs({ locateFile: file => 'https://cdnjs.cloudflare.com/ajax/libs/sql.js/1.5.0/' + file });
  }
  return _sqlJsPromise;
}

// ---------------------------------------------------------------------
// Persistent single-file storage (File System Access API)
//
// Instead of downloading a brand-new Excel/SQLite file per booking, we
// keep writing into the SAME two files: one running Excel workbook and
// one running SQLite database. The first time a guest completes a
// booking, the browser asks where to save each file; every booking after
// that (even from a different guest) re-opens that same file handle,
// appends the new record, and overwrites it in place - no duplicate
// copies pile up in the Downloads folder.
//
// This relies on the File System Access API (Chrome/Edge and other
// Chromium browsers). Where it isn't supported (Firefox, Safari), we
// fall back to accumulating records in localStorage and re-downloading
// a bundled .zip with the full, up-to-date dataset each time.
// ---------------------------------------------------------------------

const FS_ACCESS_SUPPORTED = typeof window.showSaveFilePicker === 'function';

// Tiny IndexedDB-backed key/value store, just to remember the two
// FileSystemFileHandle objects across page reloads.
function idbHandleStore() {
  return new Promise((resolve, reject) => {
    const req = indexedDB.open('cebBookingHandles', 1);
    req.onupgradeneeded = () => req.result.createObjectStore('handles');
    req.onsuccess = () => resolve(req.result);
    req.onerror = () => reject(req.error);
  });
}
async function idbGetHandle(key) {
  try {
    const db = await idbHandleStore();
    return await new Promise((resolve, reject) => {
      const tx = db.transaction('handles', 'readonly');
      const r = tx.objectStore('handles').get(key);
      r.onsuccess = () => resolve(r.result || null);
      r.onerror = () => reject(r.error);
    });
  } catch (e) { return null; }
}
async function idbSetHandle(key, handle) {
  try {
    const db = await idbHandleStore();
    await new Promise((resolve, reject) => {
      const tx = db.transaction('handles', 'readwrite');
      tx.objectStore('handles').put(handle, key);
      tx.oncomplete = () => resolve();
      tx.onerror = () => reject(tx.error);
    });
  } catch (e) { /* ignore - worst case we re-prompt next time */ }
}

// Gets (or creates, on first use) the persistent handle for 'xlsx' or
// 'sqlite'. Reuses the previously-picked file across bookings/sessions,
// re-requesting permission (a single click, no new file dialog) if the
// browser had revoked it.
async function getPersistentFileHandle(kind) {
  const key = 'cebBooking_' + kind;
  const suggestedName = kind === 'xlsx' ? 'GuestBookings.xlsx' : 'GuestBookings.sqlite';
  const types = kind === 'xlsx'
    ? [{ description: 'Excel Workbook', accept: { 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': ['.xlsx'] } }]
    : [{ description: 'SQLite Database', accept: { 'application/x-sqlite3': ['.sqlite'] } }];

  let handle = await idbGetHandle(key);
  if (handle) {
    try {
      let perm = await handle.queryPermission({ mode: 'readwrite' });
      if (perm !== 'granted') perm = await handle.requestPermission({ mode: 'readwrite' });
      if (perm === 'granted') return handle;
    } catch (e) { /* handle stale/invalid - fall through to re-pick */ }
  }

  handle = await window.showSaveFilePicker({ suggestedName, types });
  await idbSetHandle(key, handle);
  return handle;
}

// Reads whatever booking/guest/contact rows already exist in the target
// Excel file (if any), so the new row can be appended rather than
// overwriting prior guests' data.
async function readExistingWorkbookRows(handle) {
  try {
    const file = await handle.getFile();
    if (!file || file.size === 0) return null;
    const buf = await file.arrayBuffer();
    const wb = XLSX.read(buf, { type: 'array' });
    const sheetRows = (name) => wb.Sheets[name] ? XLSX.utils.sheet_to_json(wb.Sheets[name]) : [];
    return {
      bookingRows: sheetRows('Booking'),
      guestRows: sheetRows('Guest Details'),
      contactRows: sheetRows('Contact Information')
    };
  } catch (e) {
    console.warn('Could not read existing workbook, starting fresh.', e);
    return null;
  }
}

// Reads the existing SQLite file's bytes (if any) so new rows can be
// inserted into the same database rather than replacing it.
async function readExistingSqliteBytes(handle) {
  try {
    const file = await handle.getFile();
    if (!file || file.size === 0) return null;
    return new Uint8Array(await file.arrayBuffer());
  } catch (e) {
    console.warn('Could not read existing SQLite file, starting fresh.', e);
    return null;
  }
}

// Ensures the guests/contacts/bookings schema exists (safe to call on a
// brand-new database or one that already has the tables), then inserts
// one new guest + contact + booking row.
function insertBookingIntoSqliteDb(db, bookingRow, guestRow, contactRow) {
  db.run(
    'CREATE TABLE IF NOT EXISTS guests (' +
    ' id INTEGER PRIMARY KEY AUTOINCREMENT,' +
    ' full_name TEXT, title TEXT, first_name TEXT, last_name TEXT,' +
    ' date_of_birth TEXT, nationality TEXT, go_rewards_id TEXT,' +
    ' passport_number TEXT UNIQUE, passport_country_of_issue TEXT, passport_expiration_date TEXT,' +
    ' oec_mec_number TEXT, pwd_id_number TEXT' +
    ');' +
    'CREATE TABLE IF NOT EXISTS contacts (' +
    ' id INTEGER PRIMARY KEY AUTOINCREMENT,' +
    ' guest_id INTEGER REFERENCES guests(id),' +
    ' contact_name TEXT, country_code TEXT, mobile_number TEXT UNIQUE, email TEXT UNIQUE' +
    ');' +
    'CREATE TABLE IF NOT EXISTS bookings (' +
    ' id INTEGER PRIMARY KEY AUTOINCREMENT,' +
    ' guest_id INTEGER REFERENCES guests(id),' +
    ' guest_name TEXT, date_of_birth TEXT, nationality TEXT, passport_number TEXT, contact_number TEXT, email TEXT,' +
    ' origin TEXT, origin_code TEXT, destination TEXT, destination_code TEXT, trip_type TEXT,' +
    ' departure_date TEXT, departure_time TEXT, arrival_time TEXT, outbound_flight_no TEXT, outbound_price_php REAL,' +
    ' return_date TEXT, return_departure_time TEXT, return_arrival_time TEXT, return_flight_no TEXT, return_price_php REAL,' +
    ' total_price_php REAL, booked_on TEXT' +
    ');'
  );

  // Guests tables created by an earlier version of this exporter (before
  // OFW/PWD ID columns existed) won't have these columns yet - add them if
  // missing. This is a safe no-op on brand-new databases, since the
  // CREATE TABLE above already includes both columns.
  try { db.run('ALTER TABLE guests ADD COLUMN oec_mec_number TEXT'); } catch (e) {}
  try { db.run('ALTER TABLE guests ADD COLUMN pwd_id_number TEXT'); } catch (e) {}

  // Reject duplicate OFW (OEC/MEC) and PWD ID numbers the same way passport
  // numbers are rejected. NULL is stored (never '') when a guest has no
  // OFW/PWD ID, and SQLite unique indexes don't treat multiple NULLs as
  // duplicates, so guests without these IDs never collide with each other.
  db.run('CREATE UNIQUE INDEX IF NOT EXISTS idx_guests_oec_mec_number ON guests(oec_mec_number)');
  db.run('CREATE UNIQUE INDEX IF NOT EXISTS idx_guests_pwd_id_number ON guests(pwd_id_number)');

  const guestStmt = db.prepare(
    'INSERT INTO guests (full_name,title,first_name,last_name,date_of_birth,nationality,go_rewards_id,' +
    'passport_number,passport_country_of_issue,passport_expiration_date,oec_mec_number,pwd_id_number) ' +
    'VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
  );
  guestStmt.run([
    guestRow['Full Name'], guestRow['Title'], guestRow['First Name'], guestRow['Last Name'],
    guestRow['Date of Birth'], guestRow['Nationality'], guestRow['GO Rewards Membership ID'],
    guestRow['Passport Number'], guestRow['Passport Country of Issue'], guestRow['Passport Expiration Date'],
    guestRow['OEC/MEC Number'] || null, guestRow['PWD ID Number'] || null
  ]);
  guestStmt.free();
  const guestId = db.exec('SELECT last_insert_rowid()')[0].values[0][0];

  const contactStmt = db.prepare(
    'INSERT INTO contacts (guest_id,contact_name,country_code,mobile_number,email) VALUES (?,?,?,?,?)'
  );
  contactStmt.run([guestId, contactRow['Contact Name'], contactRow['Country Code'], contactRow['Mobile Number'], contactRow['Email']]);
  contactStmt.free();

  const bookingStmt = db.prepare(
    'INSERT INTO bookings (guest_id,guest_name,date_of_birth,nationality,passport_number,contact_number,email,' +
    'origin,origin_code,destination,destination_code,trip_type,departure_date,' +
    'departure_time,arrival_time,outbound_flight_no,outbound_price_php,return_date,return_departure_time,' +
    'return_arrival_time,return_flight_no,return_price_php,total_price_php,booked_on) ' +
    'VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
  );
  bookingStmt.run([
    guestId, bookingRow['Guest Name'], bookingRow['Date of Birth'], bookingRow['Nationality'],
    bookingRow['Passport Number'], bookingRow['Contact Number'], bookingRow['Email'],
    bookingRow['Origin'], bookingRow['Origin Code'], bookingRow['Destination'], bookingRow['Destination Code'],
    bookingRow['Trip Type'], bookingRow['Departure Date'], bookingRow['Departure Time'], bookingRow['Arrival Time'],
    bookingRow['Outbound Flight No.'], bookingRow['Outbound Price (PHP)'] || 0,
    bookingRow['Return Date'], bookingRow['Return Departure Time'], bookingRow['Return Arrival Time'],
    bookingRow['Return Flight No.'], bookingRow['Return Price (PHP)'] || 0,
    bookingRow['Total Price (PHP)'] || 0, bookingRow['Booked On']
  ]);
  bookingStmt.free();
}

// Fallback accumulator used only in browsers without the File System
// Access API (e.g. Firefox, Safari): keeps every booking made in this
// browser in localStorage so re-downloads always contain the full,
// up-to-date dataset rather than just the latest guest.
const LOCAL_BOOKINGS_KEY = 'cebAllBookingRecords';
function loadLocalBookingRecords() {
  try { return JSON.parse(localStorage.getItem(LOCAL_BOOKINGS_KEY)) || []; }
  catch (e) { return []; }
}
function saveLocalBookingRecords(records) {
  try { localStorage.setItem(LOCAL_BOOKINGS_KEY, JSON.stringify(records)); }
  catch (e) { console.warn('Could not persist bookings to localStorage.', e); }
}

// Builds a multi-sheet Excel (.xlsx) record of the guest's booking - a
// "Booking" sheet (route, dates, times, flight numbers, price), a "Guest
// Details" sheet (name/DOB/nationality/passport/etc.) and a "Contact
// Information" sheet - using whatever was actually selected in the Select
// Flight step and entered in the Guest Details form, then triggers a
// download. Also exports the same data as a normalized .sqlite database.
// guestInfo is the object produced by collectGuestInfoFromDoc(); if it's not
// supplied, it's collected from this page's own form as a fallback.
// Checks whether the passport number, mobile number, or email in this
// booking already exists among previously saved guest/contact rows, so
// we never write a duplicate row into the Excel file or the SQLite
// database for a passport/phone/email that's already on file.
// Returns { field, value } for the first match found, or null.
function findDuplicateGuestField(existingGuestRows, existingContactRows, guestRow, contactRow) {
  const norm = (v) => (v || '').toString().trim().toLowerCase();
  const passport = norm(guestRow['Passport Number']);
  const mobile = norm(contactRow['Mobile Number']);
  const email = norm(contactRow['Email']);
  const oecMec = norm(guestRow['OEC/MEC Number']);
  const pwdId = norm(guestRow['PWD ID Number']);

  if (passport && (existingGuestRows || []).some(r => norm(r['Passport Number']) === passport)) {
    return { field: 'Passport Number', value: guestRow['Passport Number'] };
  }
  if (mobile && (existingContactRows || []).some(r => norm(r['Mobile Number']) === mobile)) {
    return { field: 'Mobile Number', value: contactRow['Mobile Number'] };
  }
  if (email && (existingContactRows || []).some(r => norm(r['Email']) === email)) {
    return { field: 'Email', value: contactRow['Email'] };
  }
  if (oecMec && (existingGuestRows || []).some(r => norm(r['OEC/MEC Number']) === oecMec)) {
    return { field: 'OEC/MEC Number', value: guestRow['OEC/MEC Number'] };
  }
  if (pwdId && (existingGuestRows || []).some(r => norm(r['PWD ID Number']) === pwdId)) {
    return { field: 'PWD ID Number', value: guestRow['PWD ID Number'] };
  }
  return null;
}

// Shows a branded warning modal (instead of a plain browser alert()) when
// a booking can't be saved because its passport number, mobile number, or
// email already belongs to another guest on file.
function showDuplicateAlert(fieldLabel, fieldValue) {
  const overlay = document.createElement('div');
  overlay.className = 'dup-alert-overlay';

  const card = document.createElement('div');
  card.className = 'dup-alert-card';

  const icon = document.createElement('div');
  icon.className = 'dup-alert-icon';
  icon.textContent = '!';

  const title = document.createElement('h3');
  title.className = 'dup-alert-title';
  title.textContent = 'Booking Not Saved';

  const message = document.createElement('p');
  message.className = 'dup-alert-message';
  message.appendChild(document.createTextNode('The '));
  const strongField = document.createElement('strong');
  strongField.textContent = fieldLabel;
  message.appendChild(strongField);
  message.appendChild(document.createTextNode(' you entered, '));
  const valueSpan = document.createElement('span');
  valueSpan.className = 'dup-alert-value';
  valueSpan.textContent = '"' + fieldValue + '"';
  message.appendChild(valueSpan);
  message.appendChild(document.createTextNode(', is already on file for another guest.'));

  const submessage = document.createElement('p');
  submessage.className = 'dup-alert-submessage';
  submessage.textContent = 'Duplicate passport numbers, mobile numbers, and emails are not allowed.';

  const btn = document.createElement('button');
  btn.type = 'button';
  btn.className = 'dup-alert-btn';
  btn.textContent = 'OK';

  card.appendChild(icon);
  card.appendChild(title);
  card.appendChild(message);
  card.appendChild(submessage);
  card.appendChild(btn);
  overlay.appendChild(card);
  document.body.appendChild(overlay);

  const close = () => overlay.remove();
  btn.addEventListener('click', close);
  overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });
  btn.focus();
}

async function exportBookingRecord(guestName, guestInfo) {
  try {
    if (typeof XLSX === 'undefined') { console.warn('XLSX library not loaded; skipping export.'); return; }
    if (!guestInfo) guestInfo = collectGuestInfoFromDoc(document);

    const originCityFull = (originInput.value || '').trim();
    const destinationCityFull = (destinationInput.value || '').trim();
    const originCity = originCityFull.split('(')[0].trim();
    const destinationCity = destinationCityFull.split('(')[0].trim();

    function cardDetails(card) {
      if (!card) return null;
      const groups = card.querySelectorAll('.time-group');
      const depGroup = groups[0], arrGroup = groups[1];
      const depTimeEl = depGroup ? depGroup.querySelector('.time') : null;
      const depPeriodEl = depGroup ? depGroup.querySelector('.period') : null;
      const arrTimeEl = arrGroup ? arrGroup.querySelector('.time') : null;
      const arrPeriodEl = arrGroup ? arrGroup.querySelector('.period') : null;
      const fromCodeEl = depGroup ? depGroup.querySelector('.city') : null;
      const toCodeEl = arrGroup ? arrGroup.querySelector('.city') : null;
      const flightNumEl = card.querySelector('.flight-num');
      return {
        date: card.getAttribute('data-date') || '',
        depTime: (depTimeEl ? depTimeEl.textContent : '') + ' ' + (depPeriodEl ? depPeriodEl.textContent : ''),
        arrTime: (arrTimeEl ? arrTimeEl.textContent : '') + ' ' + (arrPeriodEl ? arrPeriodEl.textContent : ''),
        fromCode: fromCodeEl ? fromCodeEl.textContent : '',
        toCode: toCodeEl ? toCodeEl.textContent : '',
        flightNum: flightNumEl ? flightNumEl.textContent.trim() : '',
        price: parseFloat(card.getAttribute('data-price')) || 0
      };
    }

    const outbound = cardDetails(selectedFlightCard);
    const inbound = cardDetails(selectedReturnFlightCard);
    const totalPrice = (outbound ? outbound.price : 0) + (inbound ? inbound.price : 0);

    // Guest Name here is name-only (no title) - the title is still kept on
    // its own in the Guest Details sheet/table.
    const guestNameNoTitle = [
      (guestInfo && guestInfo.firstName) || '',
      (guestInfo && guestInfo.lastName) || ''
    ].filter(Boolean).join(' ') || (guestName || '').replace(/^(Mr\.|Ms\.|Mrs\.)\s+/i, '');

    const contactNumber = [
      (guestInfo && guestInfo.countryCode) || '',
      (guestInfo && guestInfo.mobileNumber) || ''
    ].filter(Boolean).join(' ');

    const row = {
      'Guest Name': guestNameNoTitle,
      'Date of Birth': (guestInfo && guestInfo.dob) || '',
      'Nationality': (guestInfo && guestInfo.nationality) || '',
      'Passport Number': (guestInfo && guestInfo.passportNumber) || '',
      'Contact Number': contactNumber,
      'Email': (guestInfo && guestInfo.email) || '',
      'Origin': originCity,
      'Origin Code': outbound ? outbound.fromCode : getAirportCode(originCityFull),
      'Destination': destinationCity,
      'Destination Code': outbound ? outbound.toCode : getAirportCode(destinationCityFull),
      'Trip Type': inbound ? 'Round-trip' : 'One-way',
      'Departure Date': outbound ? outbound.date : '',
      'Departure Time': outbound ? outbound.depTime.trim() : '',
      'Arrival Time': outbound ? outbound.arrTime.trim() : '',
      'Outbound Flight No.': outbound ? outbound.flightNum : '',
      'Outbound Price (PHP)': outbound ? outbound.price : '',
      'Return Date': inbound ? inbound.date : '',
      'Return Departure Time': inbound ? inbound.depTime.trim() : '',
      'Return Arrival Time': inbound ? inbound.arrTime.trim() : '',
      'Return Flight No.': inbound ? inbound.flightNum : '',
      'Return Price (PHP)': inbound ? inbound.price : '',
      'Total Price (PHP)': totalPrice,
      'Booked On': new Date().toLocaleString()
    };

    // Guest's personal details - kept on their own sheet so passport number,
    // date of birth, etc. aren't repeated alongside every booking row.
    const guestRow = {
      'Full Name': (guestInfo && guestInfo.fullName) || guestName || '',
      'Title': (guestInfo && guestInfo.title) || '',
      'First Name': (guestInfo && guestInfo.firstName) || '',
      'Last Name': (guestInfo && guestInfo.lastName) || '',
      'Date of Birth': (guestInfo && guestInfo.dob) || '',
      'Nationality': (guestInfo && guestInfo.nationality) || '',
      'GO Rewards Membership ID': (guestInfo && guestInfo.goRewardsId) || '',
      'Passport Number': (guestInfo && guestInfo.passportNumber) || '',
      'Passport Country of Issue': (guestInfo && guestInfo.passportCountry) || '',
      'Passport Expiration Date': (guestInfo && guestInfo.passportExpiry) || '',
      'OEC/MEC Number': (guestInfo && guestInfo.ofw && guestInfo.oecMecNumber) || '',
      'PWD ID Number': (guestInfo && guestInfo.pwd && guestInfo.pwdIdNumber) || ''
    };

    // Contact details for the booking - kept separate from the guest's
    // personal info sheet since a different person can be the contact.
    const contactRow = {
      'Contact Name': (guestInfo && (guestInfo.contactName || guestInfo.fullName)) || guestName || '',
      'Country Code': (guestInfo && guestInfo.countryCode) || '',
      'Mobile Number': (guestInfo && guestInfo.mobileNumber) || '',
      'Email': (guestInfo && guestInfo.email) || ''
    };

    if (FS_ACCESS_SUPPORTED) {
      // ---- Persistent path: append this booking into the SAME two files ----
      const xlsxHandle = await getPersistentFileHandle('xlsx');
      const sqliteHandle = await getPersistentFileHandle('sqlite');

      // Excel: read whatever's already in the file, append this booking's
      // rows, and rewrite the three sheets from the combined data.
      const existingWb = await readExistingWorkbookRows(xlsxHandle);

      const duplicateField = findDuplicateGuestField(
        existingWb ? existingWb.guestRows : [],
        existingWb ? existingWb.contactRows : [],
        guestRow, contactRow
      );
      if (duplicateField) {
        showDuplicateAlert(duplicateField.field, duplicateField.value);
        return;
      }

      const bookingRows = normalizeRows(
        (existingWb ? existingWb.bookingRows : []).concat([row]), BOOKING_HEADERS
      );
      const guestRows = normalizeRows(
        (existingWb ? existingWb.guestRows : []).concat([guestRow]), GUEST_HEADERS
      );
      const contactRows = normalizeRows(
        (existingWb ? existingWb.contactRows : []).concat([contactRow]), CONTACT_HEADERS
      );

      const ws = XLSX.utils.json_to_sheet(bookingRows);
      autosizeColumns(ws, bookingRows);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Booking');

      const wsGuest = XLSX.utils.json_to_sheet(guestRows);
      autosizeColumns(wsGuest, guestRows);
      XLSX.utils.book_append_sheet(wb, wsGuest, 'Guest Details');

      const wsContact = XLSX.utils.json_to_sheet(contactRows);
      autosizeColumns(wsContact, contactRows);
      XLSX.utils.book_append_sheet(wb, wsContact, 'Contact Information');

      const xlsxArrayBuffer = XLSX.write(wb, { type: 'array', bookType: 'xlsx' });
      const xlsxWritable = await xlsxHandle.createWritable();
      await xlsxWritable.write(xlsxArrayBuffer);
      await xlsxWritable.close();

      // SQLite: open the existing database bytes (if any) and insert into
      // it, rather than replacing the file with a single-booking database.
      const SQL = await getSqlJs();
      if (SQL) {
        const existingBytes = await readExistingSqliteBytes(sqliteHandle);
        const db = existingBytes ? new SQL.Database(existingBytes) : new SQL.Database();
        try {
          insertBookingIntoSqliteDb(db, row, guestRow, contactRow);
        } catch (dbErr) {
          console.error('SQLite insert failed (duplicate passport number, mobile number, or email):', dbErr);
          db.close();
          const msg = (dbErr && dbErr.message) || '';
          const guessedField = msg.indexOf('passport_number') !== -1 ? 'Passport Number'
            : msg.indexOf('mobile_number') !== -1 ? 'Mobile Number'
            : msg.indexOf('email') !== -1 ? 'Email'
            : msg.indexOf('oec_mec_number') !== -1 ? 'OEC/MEC Number'
            : msg.indexOf('pwd_id_number') !== -1 ? 'PWD ID Number'
            : 'Passport Number, Mobile Number, Email, OEC/MEC Number, or PWD ID Number';
          const guessedValue = guessedField === 'Passport Number' ? guestRow['Passport Number']
            : guessedField === 'Mobile Number' ? contactRow['Mobile Number']
            : guessedField === 'Email' ? contactRow['Email']
            : guessedField === 'OEC/MEC Number' ? guestRow['OEC/MEC Number']
            : guessedField === 'PWD ID Number' ? guestRow['PWD ID Number']
            : (guestRow['Passport Number'] || contactRow['Mobile Number'] || contactRow['Email'] || guestRow['OEC/MEC Number'] || guestRow['PWD ID Number']);
          showDuplicateAlert(guessedField, guessedValue);
          return;
        }
        const sqliteData = db.export();
        db.close();
        const sqliteWritable = await sqliteHandle.createWritable();
        await sqliteWritable.write(sqliteData);
        await sqliteWritable.close();
      }
    } else {
      // ---- Fallback path (Firefox/Safari): no direct file overwrite is
      // possible, so accumulate every booking in localStorage and
      // re-download a single zip containing the full, up-to-date Excel +
      // SQLite files every time. ----
      const allRecords = loadLocalBookingRecords();

      const duplicateField = findDuplicateGuestField(
        allRecords.map(r => r.guestRow),
        allRecords.map(r => r.contactRow),
        guestRow, contactRow
      );
      if (duplicateField) {
        showDuplicateAlert(duplicateField.field, duplicateField.value);
        return;
      }

      allRecords.push({ row, guestRow, contactRow });
      saveLocalBookingRecords(allRecords);

      const bookingRows = normalizeRows(allRecords.map(r => r.row), BOOKING_HEADERS);
      const guestRows = normalizeRows(allRecords.map(r => r.guestRow), GUEST_HEADERS);
      const contactRows = normalizeRows(allRecords.map(r => r.contactRow), CONTACT_HEADERS);

      const ws = XLSX.utils.json_to_sheet(bookingRows);
      autosizeColumns(ws, bookingRows);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, 'Booking');

      const wsGuest = XLSX.utils.json_to_sheet(guestRows);
      autosizeColumns(wsGuest, guestRows);
      XLSX.utils.book_append_sheet(wb, wsGuest, 'Guest Details');

      const wsContact = XLSX.utils.json_to_sheet(contactRows);
      autosizeColumns(wsContact, contactRows);
      XLSX.utils.book_append_sheet(wb, wsContact, 'Contact Information');

      const xlsxArrayBuffer = XLSX.write(wb, { type: 'array', bookType: 'xlsx' });

      let sqliteData = null;
      const SQL = await getSqlJs();
      if (SQL) {
        const db = new SQL.Database();
        try {
          allRecords.forEach(r => insertBookingIntoSqliteDb(db, r.row, r.guestRow, r.contactRow));
          sqliteData = db.export();
        } catch (dbErr) {
          console.error('SQLite insert failed (duplicate passport number, mobile number, or email):', dbErr);
        }
        db.close();
      }

      if (typeof JSZip !== 'undefined') {
        const zip = new JSZip();
        zip.file('GuestBookings.xlsx', xlsxArrayBuffer);
        if (sqliteData) zip.file('GuestBookings.sqlite', sqliteData);
        const zipBlob = await zip.generateAsync({ type: 'blob' });
        const url = URL.createObjectURL(zipBlob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'GuestBookings.zip';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        setTimeout(() => URL.revokeObjectURL(url), 1000);
      } else {
        console.warn('JSZip not loaded; downloading Excel file only.');
        XLSX.writeFile(wb, 'GuestBookings.xlsx');
      }
    }
  } catch (e) {
    console.error('Booking export failed', e);
  }
}

// The international guest form lives in an iframe, so it can't reach this
// page's DOM directly - it messages us instead when its Back button is
// clicked, or when its Continue button needs a booking record exported
// (along with the guest info it collected from its own form).
window.addEventListener('message', function (ev) {
  if (ev.data === 'cebGoBackToSearch') {
    document.getElementById('guestIntlView').classList.remove('active-view');
    document.getElementById('searchView').classList.add('active-view');
    window.scrollTo(0, 0);
  } else if (ev.data && ev.data.type === 'cebExportBooking') {
    
    // Trigger our new redirect function!
    proceedToAddOns();
  }
});

/* ---------- SEARCH BUTTON VALIDATION (inserted) ----------
   "Search flights" stays disabled until Origin, Destination, and a
   Depart date are all filled in - and, for round-trip searches, a
   Return date too. */
function updateSearchBtnState() {
  const hasOrigin = !!originInput.value;
  const hasDestination = !!destinationInput.value;
  const hasDepart = !!departInput.value;
  const isRoundTrip = tripTypeBtn.innerText === 'Round-trip';
  const hasReturn = !isRoundTrip || !!returnInput.value;

  searchFlightsBtn.disabled = !(hasOrigin && hasDestination && hasDepart && hasReturn);
}

// Bulletproof check to constantly ensure the button enables when fields are full
setInterval(updateSearchBtnState, 250);

// Set the correct initial state as soon as the page loads.
updateSearchBtnState();

</script>
<!-- ===== Guest Details logic (merged from guestinfos.html) ===== -->
<script>
function syncName(){
  const f = document.getElementById('firstName').value.trim();
  const l = document.getElementById('lastName').value.trim();
  document.getElementById('tabName').textContent = f ? (f.charAt(0).toUpperCase()+f.slice(1)) : (l.charAt(0).toUpperCase()+l.slice(1));
  if(document.getElementById('useGuestToggle').checked){
    syncGuestSelectFromDetails();
  }
}

function toggleFirstName(){
  const checked = document.getElementById('noFirstName').checked;
  const fn = document.getElementById('firstName');
  fn.disabled = checked;
  if(checked){ fn.value=''; syncName(); }
}

/* ---------- CUSTOM DROPDOWN ENGINE ---------- */
function buildDropdown(wrapper, input, list, options, placeholder){
  list.innerHTML = '';
  options.forEach(opt => {
    const div = document.createElement('div');
    div.className = 'opt';
    div.textContent = opt;
    div.onclick = (e) => {
      e.stopPropagation();
      input.value = opt;
      closeDropdown(wrapper);
      if(typeof clearFieldError === 'function') clearFieldError(input);
    };
    list.appendChild(div);
  });

  input.addEventListener('click', (e) => {
    e.stopPropagation();
    document.querySelectorAll('.dropdown.open').forEach(d => { if(d!==wrapper) closeDropdown(d); });
    wrapper.classList.toggle('open');
  });
}

function closeDropdown(wrapper){
  wrapper.classList.remove('open');
}

/* Searchable variant for long lists (e.g. Nationality): input is typable and filters the list */
function buildSearchableDropdown(wrapper, input, list, items, formatLabel, onSelect){
  function render(filterText){
    const f = (filterText || '').trim().toLowerCase();
    list.innerHTML = '';
    const filtered = f ? items.filter(it => formatLabel(it).toLowerCase().includes(f)) : items;
    if(filtered.length === 0){
      const div = document.createElement('div');
      div.className = 'opt';
      div.style.color = '#9aa0a6';
      div.style.cursor = 'default';
      div.textContent = 'No matches found';
      list.appendChild(div);
      return;
    }
    filtered.forEach(it => {
      const div = document.createElement('div');
      div.className = 'opt';
      div.textContent = formatLabel(it);
      div.onclick = (e) => {
        e.stopPropagation();
        onSelect(it);
        closeDropdown(wrapper);
        if(typeof clearFieldError === 'function') clearFieldError(input);
      };
      list.appendChild(div);
    });
  }

  render('');
  input.readOnly = false;

  input.addEventListener('click', (e) => {
    e.stopPropagation();
    document.querySelectorAll('.dropdown.open').forEach(d => { if(d!==wrapper) closeDropdown(d); });
    wrapper.classList.add('open');
  });

  input.addEventListener('input', () => {
    wrapper.classList.add('open');
    render(input.value);
    if(typeof clearFieldError === 'function') clearFieldError(input);
  });
}

document.addEventListener('click', () => {
  document.querySelectorAll('.dropdown.open').forEach(d => closeDropdown(d));
});

/* Day dropdown: 01-31 */
const dayOptions = Array.from({length:31}, (_,i) => String(i+1).padStart(2,'0'));
buildDropdown(
  document.getElementById('dayDropdown'),
  document.getElementById('dayInput'),
  document.getElementById('dayList'),
  dayOptions
);

/* Month dropdown */
const monthOptions = ['January','February','March','April','May','June','July','August','September','October','November','December'];
buildDropdown(
  document.getElementById('monthDropdown'),
  document.getElementById('monthInput'),
  document.getElementById('monthList'),
  monthOptions
);

/* Year dropdown: current year down to 100 years ago */
const giCurrentYear = new Date().getFullYear();
const yearOptions = Array.from({length:100}, (_,i) => String(giCurrentYear - i));
buildDropdown(
  document.getElementById('yearDropdown'),
  document.getElementById('yearInput'),
  document.getElementById('yearList'),
  yearOptions
);

const NATIONALITY_OPTIONS = [
  {name:'Philippines, Republic of the', code:'63'},
  {name:'Afghanistan', code:'93'},
  {name:'Aland Islands', code:'358'},
  {name:'Albania, People\'s Socialist Republic of', code:'355'},
  {name:'Algeria, People\'s Democratic Republic of', code:'213'},
  {name:'American Samoa', code:'1684'},
  {name:'Andorra, Principality of', code:'376'},
  {name:'Angola, Republic of', code:'244'},
  {name:'Anguilla', code:'1264'},
  {name:'Antigua and Barbuda', code:'1268'},
  {name:'Argentina, Argentine Republic', code:'54'},
  {name:'Armenia', code:'374'},
  {name:'Aruba', code:'297'},
  {name:'Australia', code:'61'},
  {name:'Austria, Republic of', code:'43'},
  {name:'Azerbaijan, Rpublic of', code:'994'},
  {name:'Bahamas, Commonwealth of the', code:'1242'},
  {name:'Bahrain, Kingdom of', code:'973'},
  {name:'Bangladesh, People\'s Republic of', code:'880'},
  {name:'Barbados', code:'1246'},
  {name:'Belarus', code:'375'},
  {name:'Belgium, Kingdom of', code:'32'},
  {name:'Belize', code:'501'},
  {name:'Benin (Was Dahomey), People\'s Republic of', code:'229'},
  {name:'Bermuda', code:'1441'},
  {name:'Bhutan, Kingdom of', code:'975'},
  {name:'Bolivia, Republic of', code:'591'},
  {name:'Bosnia and Herzegovina', code:'387'},
  {name:'Botswana, Republic of', code:'267'},
  {name:'Brazil, Federative Republic of', code:'55'},
  {name:'British Virgin Islands', code:'1284'},
  {name:'Brunei, Darussalam', code:'673'},
  {name:'Bulgaria, Republic of', code:'359'},
  {name:'Burkini Faso(was Upper Volta)', code:'226'},
  {name:'Burundi, Republic of', code:'257'},
  {name:'Cambodia', code:'855'},
  {name:'Cameroon, United Republic of', code:'237'},
  {name:'Canada', code:'1'},
  {name:'Cape Verde, Republic of', code:'238'},
  {name:'Cayman Islands', code:'1345'},
  {name:'Central African Republic', code:'236'},
  {name:'Chad, Republic of', code:'235'},
  {name:'Chile, Republic of', code:'56'},
  {name:'China', code:'86'},
  {name:'Christmas Islands', code:'61'},
  {name:'Cocos(Keeling) Islands', code:'61'},
  {name:'Colombia, Republic of', code:'57'},
  {name:'Comoros, Union of the ', code:'269'},
  {name:'Congo, Democratic Republic of(was Zaire)', code:'243'},
  {name:'Cook Islands', code:'682'},
  {name:'Costa Rica, Republic of', code:'506'},
  {name:'Croatia', code:'385'},
  {name:'Cuba, Republic of', code:'53'},
  {name:'Curacao, ', code:'599'},
  {name:'Cyprus, Republic of', code:'357'},
  {name:'Czech Republic', code:'420'},
  {name:'Denmark, Kingdom of', code:'45'},
  {name:'Djibouti, Republic of(French Afas and Isaac)', code:'253'},
  {name:'Dominica, Commonwealth of', code:'1767'},
  {name:'Dominican Republic', code:'1809'},
  {name:'Ecuador, Republic of', code:'593'},
  {name:'Egypt, Arab Republic of', code:'20'},
  {name:'El Salvador, Republic of', code:'503'},
  {name:'Equatorial Guinea, Republic of', code:'240'},
  {name:'Eritrea', code:'291'},
  {name:'Estonia', code:'372'},
  {name:'Eswatini', code:'268'},
  {name:'Ethiopia', code:'251'},
  {name:'Faeroe Islands', code:'298'},
  {name:'Falkland Islands (Malvinas)', code:'500'},
  {name:'Fiji, Republic of the Fiji Islands', code:'679'},
  {name:'Finland, Republic of', code:'358'},
  {name:'France, French Republic', code:'33'},
  {name:'French Guiana', code:'594'},
  {name:'French Polynesia', code:'689'},
  {name:'French Southern Territories', code:'262'},
  {name:'Gabon, Gabonese Republic', code:'241'},
  {name:'Gambia, Republic of the', code:'220'},
  {name:'Georgia', code:'995'},
  {name:'Germany', code:'49'},
  {name:'Ghana, Rpublic of', code:'233'},
  {name:'Gilbratar', code:'350'},
  {name:'Greece, Hellenic Republic', code:'30'},
  {name:'Greenlanda', code:'299'},
  {name:'Grenada', code:'1473'},
  {name:'Guadoloupe', code:'590'},
  {name:'Guam', code:'1671'},
  {name:'Guatamela, Republic of', code:'502'},
  {name:'Guernsey', code:'44'},
  {name:'Guinea-Bissau, Republic of (was Portugese Guinea)', code:'245'},
  {name:'Guinea, Revolutionary People\'s Rep\'c of', code:'224'},
  {name:'Guyana, Republic of', code:'592'},
  {name:'Haiti, Republic of', code:'509'},
  {name:'Heard and McDonald Islands', code:'672'},
  {name:'Holy See(Vatican City State)', code:'379'},
  {name:'Honduras, Republic of', code:'504'},
  {name:'Hong Kong(China)', code:'852'},
  {name:'Hungary', code:'36'},
  {name:'Iceland, Republic of', code:'354'},
  {name:'India, Republic of', code:'91'},
  {name:'Indonesia', code:'62'},
  {name:'Iran, Islamic Republic of', code:'98'},
  {name:'Iraq, Republic of', code:'964'},
  {name:'Ireland', code:'353'},
  {name:'Isle of Man', code:'44'},
  {name:'Israel, State of', code:'972'},
  {name:'Italy, Italian Republic', code:'39'},
  {name:'Ivory Coast(was Cote D\'Ivore), Republic of the', code:'225'},
  {name:'Jamaica', code:'1876'},
  {name:'Japan', code:'81'},
  {name:'Jersey', code:'44'},
  {name:'Jordan, Hashemite Kingdom of', code:'962'},
  {name:'Kazakhstan, Republic of', code:'7'},
  {name:'Kenya, Republic of', code:'254'},
  {name:'Kiribati, Republic of (was Gilbert Islands)', code:'686'},
  {name:'Korea, Democratic People\'s Republic of', code:'850'},
  {name:'Korea', code:'82'},
  {name:'Kuwait', code:'965'},
  {name:'Kyrgyz Republic', code:'996'},
  {name:'Laos, People\'s Democratic Repbublic of', code:'856'},
  {name:'Latvia', code:'371'},
  {name:'Lebanon, Lebanese Republic', code:'961'},
  {name:'Lesotho, Kingdom of', code:'266'},
  {name:'Liberia, Republic of', code:'231'},
  {name:'Libya', code:'218'},
  {name:'Liechtenstein, Principality of', code:'423'},
  {name:'Lithuania', code:'370'},
  {name:'Luxembourg, Grand Duchy of', code:'352'},
  {name:'Macau(China)', code:'853'},
  {name:'North Macedonia', code:'389'},
  {name:'Madagascar, Republic of', code:'261'},
  {name:'Malawi, Republic of', code:'265'},
  {name:'Malaysia', code:'60'},
  {name:'Maldives, Republic of', code:'960'},
  {name:'Mali, Republic of', code:'223'},
  {name:'Malta, Republic of', code:'356'},
  {name:'Marshall Islands', code:'692'},
  {name:'Martinique', code:'596'},
  {name:'Mauritania, Islamic Republic of', code:'222'},
  {name:'Mauritius', code:'230'},
  {name:'Mayotte', code:'262'},
  {name:'Mexico, United Mexican States', code:'52'},
  {name:'Micronesia, Federated States of', code:'691'},
  {name:'Moldova, Republic of', code:'373'},
  {name:'Monaco, Principality of', code:'377'},
  {name:'Mongolia, Mongolian People\'s Republic', code:'976'},
  {name:'Monteserrat', code:'1664'},
  {name:'Montenegro', code:'382'},
  {name:'Morocco, Kingdom of', code:'212'},
  {name:'Mozambique, People\'s Republic', code:'258'},
  {name:'Namibia', code:'264'},
  {name:'Nauru, Republic of', code:'674'},
  {name:'Nepal, Kingdom of', code:'977'},
  {name:'Netherlands, Kingdom of the', code:'31'},
  {name:'New Caledonia', code:'687'},
  {name:'New Zealand', code:'64'},
  {name:'Nicaragua, Republic of', code:'505'},
  {name:'Niger, Republic of the', code:'227'},
  {name:'Nigeria, Rederal Republic of', code:'234'},
  {name:'Niue, Republic of', code:'683'},
  {name:'Norfolk Islands', code:'672'},
  {name:'Northern Mariana Islands', code:'1670'},
  {name:'Norway, Kingdom of', code:'47'},
  {name:'Oman, Sultanate of(was Muscat and Oman)', code:'968'},
  {name:'Pakistan, Islamic Republic of', code:'92'},
  {name:'Palau', code:'680'},
  {name:'Palestinian Territory, Occupied', code:'970'},
  {name:'Panama, Republic off', code:'507'},
  {name:'Papua New Guinea', code:'675'},
  {name:'Paraguay, Repblic of', code:'595'},
  {name:'Peru, Republic of', code:'51'},
  {name:'Pitcairn Island', code:'64'},
  {name:'Poland, Republic of', code:'48'},
  {name:'Portugal, Portugenese Republic', code:'351'},
  {name:'Puerto Rico', code:'1787'},
  {name:'Qatar', code:'974'},
  {name:'Republic of Kosovo', code:'383'},
  {name:'Reunion', code:'262'},
  {name:'Romania', code:'40'},
  {name:'Russia Federation', code:'7'},
  {name:'Rwanda, Rwandese Republic', code:'250'},
  {name:'Saint Barthelemy', code:'590'},
  {name:'Saint Martin', code:'590'},
  {name:'Samoa, Independent State of(was Western Samoa)', code:'685'},
  {name:'San Marino, Republic of', code:'378'},
  {name:'Sao Tome and Principe, Democratic Republic of', code:'239'},
  {name:'Saudi Arabia, Kingdom of', code:'966'},
  {name:'Serbia', code:'381'},
  {name:'Serbia and Montenegro', code:'381'},
  {name:'Senegal, Republic of', code:'221'},
  {name:'Seychelles, Republic of', code:'248'},
  {name:'Sierra Leone, Republic of', code:'232'},
  {name:'Singapore', code:'65'},
  {name:'Sint Maarten', code:'1721'},
  {name:'Slovakia, Slovak Republic', code:'421'},
  {name:'Slovenia', code:'386'},
  {name:'Solomon Islands(was British Solomon Islands)', code:'677'},
  {name:'Somalia, Somali Republic', code:'252'},
  {name:'South Africa, Republic of', code:'27'},
  {name:'South Georgia and the South Sandwich Islands', code:'500'},
  {name:'South Sudan', code:'211'},
  {name:'Spain, Spanish State', code:'34'},
  {name:'Sri Lanka, Democratic Socialist Republic of(was Ceylon)', code:'94'},
  {name:'St. Helena', code:'290'},
  {name:'St. Kitts and Nevis', code:'1869'},
  {name:'St. Lucia', code:'1758'},
  {name:'St. Pierre and Miquelon', code:'508'},
  {name:'St. Vincent and the Grenadines', code:'1784'},
  {name:'Sudan, Democratic Republic of the', code:'249'},
  {name:'Suriname, Republic of', code:'597'},
  {name:'Svalbard & Jan Mayen Islands', code:'47'},
  {name:'Swaziland, Kingdom of', code:'268'},
  {name:'Swedem, Kingdom of', code:'46'},
  {name:'Switzerland, Swiss Confederation', code:'41'},
  {name:'Syrean Arab Republic', code:'963'},
  {name:'Taiwan', code:'886'},
  {name:'Tajikistan', code:'992'},
  {name:'Tanzania, United Republic of', code:'255'},
  {name:'Thailand', code:'66'},
  {name:'Timor-Leste, Democratic Republic of', code:'670'},
  {name:'Togo, Togolese Republic', code:'228'},
  {name:'Tokelau(Tokelau Islands)', code:'690'},
  {name:'Tonga, Kingdom of', code:'676'},
  {name:'Trinidad and Tobago, Republic of', code:'1868'},
  {name:'Tunisia, Republic of', code:'216'},
  {name:'Turkey, Republic of', code:'90'},
  {name:'Turkmenistan', code:'993'},
  {name:'Turks and Caicos Islands', code:'1649'},
  {name:'Tuvalu(was part of Gilbert & Ellice Islands)', code:'688'},
  {name:'Uganda, Republic of', code:'256'},
  {name:'Ukraine', code:'380'},
  {name:'United Arab Emirates', code:'971'},
  {name:'United Kingdom', code:'44'},
  {name:'United States Minor Outlying Islands', code:'1'},
  {name:'United States of America', code:'1'},
  {name:'Uruguay, Eastern Republic of', code:'598'},
  {name:'US Virgin Islands', code:'1340'},
  {name:'Uzbekistan', code:'998'},
  {name:'Vanuatu(was New Herbrides)', code:'678'},
  {name:'Venezuela, Bolivarian Republic of', code:'58'},
  {name:'Vietnam', code:'84'},
  {name:'Wallis and Futun Islands', code:'681'},
  {name:'Western Sahara(was Spanish Sahara)', code:'212'},
  {name:'Yemen', code:'967'},
  {name:'Zambia, Republic of', code:'260'},
  {name:'Zimbabwe(was Southern Rhodesia)', code:'263'}
];

buildSearchableDropdown(
  document.getElementById('countryCodeDropdown'),
  document.getElementById('countryCodeInput'),
  document.getElementById('countryCodeList'),
  NATIONALITY_OPTIONS,
  (it) => it.name + ' (+' + it.code + ')',
  (it) => {
    document.getElementById('countryCodeInput').value = '(+' + it.code + ')';
    const mobileEl = document.getElementById('mobileInput');
    if(mobileEl && typeof validateRequiredField === 'function') validateRequiredField(mobileEl);
  }
);

function toggleGuestSelect(){
  const on = document.getElementById('useGuestToggle').checked;
  document.getElementById('guestSelectBlock').style.display = on ? 'block' : 'none';
  document.getElementById('manualNameBlock').style.display = on ? 'none' : 'block';
  if(on){
    syncGuestSelectFromDetails();
    ['contactTitle','contactFirstName','contactLastName'].forEach(id=>{
      const el=document.getElementById(id);
      if(el && typeof clearFieldError==='function') clearFieldError(el);
    });
  }
}

function syncGuestSelectFromDetails(){
  const first = document.getElementById('firstName').value.trim();
  const last = document.getElementById('lastName').value.trim();
  const select = document.getElementById('guestSelect');
  const fullName = (first + ' ' + last).trim();

  if(fullName){
    select.innerHTML = `<option value="guest1" selected>${fullName}</option>`;
  } else {
    select.innerHTML = `<option value="" selected disabled>Select a guest</option>`;
  }
}

function toggleContactFirstName(){
  const checked = document.getElementById('contactNoFirstName').checked;
  const fn = document.getElementById('contactFirstName');
  fn.disabled = checked;
  if(checked){ fn.value=''; }
}

function validateMobile(){
  // Presence-based, same rule as every other field: something typed clears
  // the error, an empty box shows it. Real-time toggling itself is handled
  // by the shared validateRequiredField() listener; this just keeps the
  // Continue button state in sync as the user types.
  checkFormValid();
}

function checkFormValid(){
  const terms = document.getElementById('termsCheck').checked;
  const btn = document.getElementById('guestContinueBtn');
  if(terms){
    btn.classList.add('enabled');
  } else {
    btn.classList.remove('enabled');
  }
}

function handleContinue(){
  // Force a validation check on click just in case
  checkFormValid();
  
  const btn = document.getElementById('guestContinueBtn');
  if(btn && !btn.classList.contains('enabled')){
    alert('Please complete all required fields and accept the Privacy Policy to continue.');
    return;
  }
  
  // Instantly save data and move to Add-ons/Next page
  if (typeof proceedToAddOns === 'function') {
      proceedToAddOns();
  } else {
      window.location.href = 'AOMain-index.html';
  }
}

// init
toggleGuestSelect();
</script>
<script>
/* ---------- Shared required-field definitions ---------- */
const REQUIRED_FIELDS=[
['title','Please select title'],
['firstName','Please enter your first name'],
['lastName','Please enter your last name'],
['dayInput','Please select day'],
['monthInput','Please select month'],
['yearInput','Please select year'],
['nationalitySelect','Please select your nationality'],
['contactTitle','Please select your title'],
['contactFirstName','Please enter your first name'],
['contactLastName','Please enter your last name'],
['countryCodeInput','Please select country code'],
['mobileInput','Please enter a valid mobile number'],
['contactEmail','Please enter your email'],
['contactEmailRetype','Please enter your email']
];  
const REQUIRED_MSG={};
REQUIRED_FIELDS.forEach(r=>REQUIRED_MSG[r[0]]=r[1]);

// Some fields become optional depending on toggles/checkboxes elsewhere on the page
function isFieldSkipped(id){
  const usingGuestDetails = document.getElementById('useGuestToggle').checked;
  if(id==='firstName') return document.getElementById('noFirstName').checked;
  if(id==='contactTitle' || id==='contactLastName') return usingGuestDetails;
  if(id==='contactFirstName') return usingGuestDetails || document.getElementById('contactNoFirstName').checked;
  return false;
}

/* ---------- Format validation (name fields + email + mobile number) ----------
   Names: letters (incl. accented Filipino/Spanish characters), spaces, hyphens,
   apostrophes, and periods only - no digits or other symbols.
   Email: standard user@domain.tld shape, e.g. andrewcruz@gmail.com.
   Mobile number: the field only holds the local/national number (the country
   code is picked separately), so it must be digits only. If the selected
   country code is the Philippines (+63), it must be the standard 10-digit
   PH mobile format starting with 9 (e.g. 9998043744). For any other country
   code (or none selected), accept a generic international national number:
   7-14 digits. Blocks Continue until fixed. */
const NAME_REGEX = /^[A-Za-zÀ-ÖØ-öø-ÿ.'-]+(?:\s+[A-Za-zÀ-ÖØ-öø-ÿ.'-]+)*$/;
const NAME_FORMAT_MSG = 'Please enter a valid name using letters only (spaces, hyphens, apostrophes, and periods are allowed)';
const EMAIL_REGEX = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9-]+(?:\.[A-Za-z0-9-]+)*\.[A-Za-z]{2,}$/;
const EMAIL_FORMAT_MSG = 'Please enter a valid email address (e.g. andrewcruz@gmail.com)';
const PH_MOBILE_REGEX = /^9\d{9}$/;
const INTL_MOBILE_REGEX = /^\d{7,14}$/;
const PH_MOBILE_FORMAT_MSG = 'Please enter a valid PH mobile number (10 digits starting with 9, e.g. 9998043744)';
const INTL_MOBILE_FORMAT_MSG = 'Please enter a valid mobile number (digits only, 7-14 digits)';

function getSelectedCountryCallingCode(){
  const el = document.getElementById('countryCodeInput');
  if(!el) return '';
  const m = el.value.match(/\d+/);
  return m ? m[0] : '';
}
function mobileCountryIsPH(){
  return getSelectedCountryCallingCode() === '63';
}
const FORMAT_VALIDATORS = {
  firstName: { test:v=>NAME_REGEX.test(v), msg:NAME_FORMAT_MSG },
  lastName: { test:v=>NAME_REGEX.test(v), msg:NAME_FORMAT_MSG },
  contactFirstName: { test:v=>NAME_REGEX.test(v), msg:NAME_FORMAT_MSG },
  contactLastName: { test:v=>NAME_REGEX.test(v), msg:NAME_FORMAT_MSG },
  contactEmail: { test:v=>EMAIL_REGEX.test(v), msg:EMAIL_FORMAT_MSG },
  contactEmailRetype: { test:v=>EMAIL_REGEX.test(v), msg:EMAIL_FORMAT_MSG },
  mobileInput: {
    test:v=> mobileCountryIsPH() ? PH_MOBILE_REGEX.test(v) : INTL_MOBILE_REGEX.test(v),
    msg:()=> mobileCountryIsPH() ? PH_MOBILE_FORMAT_MSG : INTL_MOBILE_FORMAT_MSG
  }
};

// Fields that already have a hard-coded error element in the markup instead of an auto-generated one
const DEDICATED_ERROR_EL={ mobileInput:'mobileError' };

function getErrorEl(el,create){
  if(DEDICATED_ERROR_EL[el.id]) return document.getElementById(DEDICATED_ERROR_EL[el.id]);
  let e=el.parentElement.querySelector('.error-msg.auto');
  if(!e && create){ e=document.createElement('div'); e.className='error-msg auto'; el.parentElement.appendChild(e); }
  return e;
}
function showFieldError(el,msg){
  const e=getErrorEl(el,true);
  if(e){ e.textContent=msg; e.classList.add('show'); }
  el.classList.add('invalid');
}
function clearFieldError(el){
  const e=getErrorEl(el,false);
  if(e) e.classList.remove('show');
  el.classList.remove('invalid');
}

// Clears every validation error currently shown in the guest details view
// (used by the Back button so the form doesn't carry errors back to it later)
function resetGuestFormErrors(){
  const guestView=document.getElementById('guestView');
  if(!guestView) return;
  guestView.querySelectorAll('.invalid').forEach(el=>el.classList.remove('invalid'));
  guestView.querySelectorAll('.error-msg').forEach(el=>el.classList.remove('show'));
  guestView.querySelectorAll('.error-msg.auto').forEach(el=>el.remove());
}

// Wipes every field the guest typed/selected back to its original empty state
// and re-syncs all the dependent UI (toggles, visibility, tab name, guest
// select), then clears any leftover errors. Used by the Back button so
// returning to Guest Details later starts completely fresh.
function resetGuestForm(){
  // Name
  const title=document.getElementById('title'); if(title) title.selectedIndex=0;
  const firstName=document.getElementById('firstName'); if(firstName){ firstName.value=''; firstName.disabled=false; }
  const lastName=document.getElementById('lastName'); if(lastName) lastName.value='';
  const noFirstName=document.getElementById('noFirstName'); if(noFirstName) noFirstName.checked=false;

  // Date of birth & nationality
  const dayInput=document.getElementById('dayInput'); if(dayInput) dayInput.value='';
  const monthInput=document.getElementById('monthInput'); if(monthInput) monthInput.value='';
  const yearInput=document.getElementById('yearInput'); if(yearInput) yearInput.value='';
  const nationalitySelect=document.getElementById('nationalitySelect'); if(nationalitySelect) nationalitySelect.selectedIndex=0;

  // Contact information
  const useGuestToggle=document.getElementById('useGuestToggle'); if(useGuestToggle) useGuestToggle.checked=true;
  const contactTitle=document.getElementById('contactTitle'); if(contactTitle) contactTitle.selectedIndex=0;
  const contactFirstName=document.getElementById('contactFirstName'); if(contactFirstName){ contactFirstName.value=''; contactFirstName.disabled=false; }
  const contactLastName=document.getElementById('contactLastName'); if(contactLastName) contactLastName.value='';
  const contactNoFirstName=document.getElementById('contactNoFirstName'); if(contactNoFirstName) contactNoFirstName.checked=false;
  const countryCodeInput=document.getElementById('countryCodeInput'); if(countryCodeInput) countryCodeInput.value='';
  const mobileInput=document.getElementById('mobileInput'); if(mobileInput) mobileInput.value='';
  const contactEmail=document.getElementById('contactEmail'); if(contactEmail) contactEmail.value='';
  const contactEmailRetype=document.getElementById('contactEmailRetype'); if(contactEmailRetype) contactEmailRetype.value='';

  const termsCheck=document.getElementById('termsCheck'); if(termsCheck) termsCheck.checked=false;

  // Re-sync dependent visibility/state now that the underlying values changed
  if(typeof toggleFirstName==='function') toggleFirstName();
  if(typeof toggleContactFirstName==='function') toggleContactFirstName();
  if(typeof toggleGuestSelect==='function') toggleGuestSelect();

  const tabName=document.getElementById('tabName'); if(tabName) tabName.textContent='Guest';

  if(typeof checkFormValid==='function') checkFormValid();
  resetGuestFormErrors();
}
// Automatically trigger validation when typing or changing options
document.addEventListener('DOMContentLoaded', function() {
    const allInputs = document.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('input', checkFormValid);
        input.addEventListener('change', checkFormValid);
    });
    
    const termsEl = document.getElementById('termsCheck');
    if (termsEl) {
        termsEl.addEventListener('change', checkFormValid);
    }
    
    checkFormValid(); // Run on load
});

function checkEmailMatch(){
  const e1=document.getElementById('contactEmail');
  const e2=document.getElementById('contactEmailRetype');
  if(!e1||!e2) return;
  if(e2.value.trim() && e1.value.trim() && e1.value.trim()!==e2.value.trim()){
    showFieldError(e2,'Emails do not match');
  }
}

// The single rule for every required field: empty -> show its error, has a value -> clear it.
// Fields with a FORMAT_VALIDATORS entry additionally must match their expected pattern
// (e.g. names must be letters only) before the error clears.
function validateRequiredField(el){
  if(!el || !el.id || !(el.id in REQUIRED_MSG || el.id in FORMAT_VALIDATORS)) return;
  const required = el.id in REQUIRED_MSG;
  if(required && isFieldSkipped(el.id)){ clearFieldError(el); return; }
  if(required && !el.value.trim()){ showFieldError(el, REQUIRED_MSG[el.id]); return; }
  const fv = FORMAT_VALIDATORS[el.id];
  if(fv && el.value.trim() && !fv.test(el.value.trim())){
    showFieldError(el, typeof fv.msg==='function' ? fv.msg() : fv.msg);
    return;
  }
  clearFieldError(el);
  if(el.id==='contactEmail' || el.id==='contactEmailRetype') checkEmailMatch();
}

// Checkbox/toggle -> the field(s) whose required-ness depends on it
const DEPENDENTS={
  noFirstName:['firstName'],
  contactNoFirstName:['contactFirstName'],
  countryCodeInput:['mobileInput']
};

document.addEventListener('input', function(ev){
  const t=ev.target; if(!t) return;
  if(t.id in REQUIRED_MSG || t.id in FORMAT_VALIDATORS){ validateRequiredField(t); return; }
  if(t.value && t.value.trim()) clearFieldError(t);
});
document.addEventListener('change', function(ev){
  const t=ev.target; if(!t) return;
  if(t.id in REQUIRED_MSG || t.id in FORMAT_VALIDATORS){ validateRequiredField(t); }
  else if(t.tagName==='SELECT'){
    if(!t.closest('#manualNameBlock') && (t.previousElementSibling||{}).classList?.contains('field-label') && t.selectedIndex===0){
      showFieldError(t,'This field is required');
    } else clearFieldError(t);
  } else if(t.value && t.value.trim()){
    clearFieldError(t);
  }
  // A toggle just changed — re-check whichever fields depend on it (shows the
  // error immediately if that field is now required and still empty, or
  // clears it if the field just became optional)
  if(DEPENDENTS[t.id]){
    DEPENDENTS[t.id].forEach(id=>{
      const dep=document.getElementById(id);
      if(dep) validateRequiredField(dep);
    });
  }
});

// Visual order on the page: name/DOB/nationality, then declaration, then PWD, then contact info.
// Split here so Continue-button validation checks (and scrolls to) declaration errors before PWD ones.
const PRE_DECL_FIELDS=['title','firstName','lastName','dayInput','monthInput','yearInput','nationalitySelect'];
const POST_DECL_FIELDS=['contactTitle','contactFirstName','contactLastName','countryCodeInput','mobileInput','contactEmail','contactEmailRetype'];

document.getElementById('guestContinueBtn').onclick=function(ev){
 let ok=true;
 function checkRequired(id){
  let el=document.getElementById(id); if(!el)return;
  if(isFieldSkipped(id)){ clearFieldError(el); return; }
  if(!el.value.trim()){showFieldError(el,REQUIRED_MSG[id]); if(ok){el.scrollIntoView({behavior:'smooth',block:'center'});el.focus();} ok=false; return;}
  const fv=FORMAT_VALIDATORS[id];
  if(fv && !fv.test(el.value.trim())){showFieldError(el, typeof fv.msg==='function' ? fv.msg() : fv.msg); if(ok){el.scrollIntoView({behavior:'smooth',block:'center'});el.focus();} ok=false; return;}
  clearFieldError(el);
 }
 PRE_DECL_FIELDS.forEach(checkRequired);
 POST_DECL_FIELDS.forEach(checkRequired);
 document.querySelectorAll('select').forEach(s=>{
   if(s.closest('#manualNameBlock')) return;
   if(s.id in REQUIRED_MSG) return;
   if((s.previousElementSibling||{}).classList?.contains('field-label') && s.selectedIndex==0){
      showFieldError(s,'This field is required');
      if(ok){s.scrollIntoView({behavior:'smooth',block:'center'});s.focus();}
      ok=false;
   } else clearFieldError(s);
 });
 checkEmailMatch();
 const retype=document.getElementById('contactEmailRetype');
 if(retype && retype.classList.contains('invalid')) ok=false;
 const termsCard=document.querySelector('.terms-card');
 if(!document.getElementById('termsCheck').checked){
   termsCard.classList.add('invalid');
   if(ok){termsCard.scrollIntoView({behavior:'smooth',block:'center'});}
   ok=false;
 } else {
   termsCard.classList.remove('invalid');
 }
 if(!ok){ev.preventDefault();return false;}
 // Grab the name they typed and pass it to our function
 const titleEl = document.getElementById('title');
 const guestFullName = [
   (titleEl && titleEl.selectedIndex > 0) ? titleEl.value : '',
   document.getElementById('firstName').value.trim(),
   document.getElementById('lastName').value.trim()
 ].filter(Boolean).join(' ');

 proceedToAddOns(guestFullName);
}

// --- BULLETPROOF ADD-ONS TRANSITION & DATA SAVER ---
function proceedToAddOns() {
    // 1. Capture Passenger Name from the form inputs
    const titleEl = document.getElementById('title');
    const title = (titleEl && titleEl.selectedIndex > 0) ? titleEl.value : '';
    const fName = document.getElementById('firstName') ? document.getElementById('firstName').value.trim() : '';
    const lName = document.getElementById('lastName') ? document.getElementById('lastName').value.trim() : '';
    
    const guestFullName = [title, fName, lName].filter(Boolean).join(' ') || 'Valued Guest';

    // 2. Safely capture Date of Birth
    const dayVal = document.getElementById('dayInput') ? document.getElementById('dayInput').value : '01';
    const monthVal = document.getElementById('monthInput') ? document.getElementById('monthInput').value : 'January';
    const yearVal = document.getElementById('yearInput') ? document.getElementById('yearInput').value : '2000';
    const passengerDOB = `${yearVal}-${monthVal}-${dayVal}`;

    // 3. Grab Guests Count
    const adultsCount = parseInt(document.getElementById('adults-select') ? document.getElementById('adults-select').value : 1) || 1;

    // 4. Grab Departing Flight Details
    let departObj = null;
    if (typeof selectedFlightCard !== 'undefined' && selectedFlightCard) {
         const priceText = selectedFlightCard.querySelector('.price-amount').innerText.replace(/[^0-9.]/g, '');
         departObj = { 
             routeLabel: document.getElementById('routeCities').innerText, 
             dateLabel: document.getElementById('depart-input').value, 
             subtotal: parseFloat(priceText) || 0 
         };
    }

    // 5. Grab Returning Flight Details (Crucial for Roundtrip!)
    let returnObj = null;
    const returnPageEl = document.getElementById('returnFlightPage');
    const isRoundTrip = returnPageEl && returnPageEl.style.display !== 'none';
    
    if (isRoundTrip && typeof selectedReturnFlightCard !== 'undefined' && selectedReturnFlightCard) {
         const priceText = selectedReturnFlightCard.querySelector('.price-amount').innerText.replace(/[^0-9.]/g, '');
         returnObj = { 
             routeLabel: document.getElementById('retRouteCities').innerText, 
             dateLabel: document.getElementById('return-input').value, 
             subtotal: parseFloat(priceText) || 0 
         };
    }

    // 6. Save everything securely into localStorage for the Add-ons & Confirmation pages
    const cebuBooking = {
        guestName: guestFullName,
        dob: passengerDOB,
        adults: adultsCount,
        depart: departObj,
        return: returnObj
    };

    localStorage.setItem('cebuBooking', JSON.stringify(cebuBooking));
    localStorage.setItem('cebuAddons', JSON.stringify({ baggage: 0, seat: 0, travelsure: 0, meals: 0 })); 

    // 7. Redirect to your Add-ons page file
    window.location.href = 'AOMain-index.html';
}

// Automatically populate search parameters if coming from the homepage
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const originParam = urlParams.get('origin');
    const destParam = urlParams.get('destination');
    const departParam = urlParams.get('depart');
    const returnParam = urlParams.get('return');

    if (originParam && destParam) {
        const origInput = document.getElementById('origin-input');
        const destInput = document.getElementById('destination-input');
        if (origInput) origInput.value = originParam;
        if (destInput) destInput.value = destParam;

        const routeCities = document.getElementById('routeCities');
        const summaryRouteText = document.getElementById('summaryRouteText');
        if (routeCities) routeCities.innerText = originParam + ' to ' + destParam;
        if (summaryRouteText) summaryRouteText.innerText = originParam + ' to ' + destParam;

        if (departParam) {
            const depInput = document.getElementById('depart-input');
            if (depInput) depInput.value = departParam;
        }

        if (returnParam) {
            const retInput = document.getElementById('return-input');
            if (retInput) retInput.value = returnParam;

            const tripTypeBtn = document.getElementById('tripTypeBtn');
            if (tripTypeBtn) tripTypeBtn.innerText = 'Round-trip';
            const returnBox = document.getElementById('return-box');
            if (returnBox) returnBox.closest('.form-group').style.display = 'flex';
        } else {
            const tripTypeBtn = document.getElementById('tripTypeBtn');
            if (tripTypeBtn) tripTypeBtn.innerText = 'One-way';
            const returnBox = document.getElementById('return-box');
            if (returnBox) returnBox.closest('.form-group').style.display = 'none';
        }

        setTimeout(function() {
            if (typeof updateSearchBtnState === 'function') updateSearchBtnState();
            const searchBtn = document.getElementById('searchFlightsBtn');
            if (searchBtn) {
                searchBtn.disabled = false;
                searchBtn.click();
            }
        }, 300);
    }
});
</script>
</body>
</html>