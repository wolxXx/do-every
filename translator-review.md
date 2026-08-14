# Translator Review – `src/Util/Translator/`

Review von `English.php` und `German.php`. Punkte mit `[?]` brauchen deine Klärung, alle anderen können direkt umgesetzt werden.

Reihenfolge = Vorschlag für die Abarbeitung (grob nach Dringlichkeit / Risiko).

---

## 1. Klare Fehler (Bugs / Tippfehler)

- [ ] **1.1 `English.php::addPassword()` – Tippfehler**
  - Datei/Zeile: `src/Util/Translator/English.php:1392`
  - Ist: `return 'ass password';`
  - Soll: `return 'add password';`

- [ ] **1.2 `German.php::workerDidNothing()` – Akkusativ fehlt**
  - Datei/Zeile: `src/Util/Translator/German.php:1062`
  - Ist: `'- ' . … . ' hat bisher kein Beitrag geleistet -'`
  - Soll: `'- ' . … . ' hat bisher keinen Beitrag geleistet -'`

- [ ] **1.3 `German.php::dashboardLastPasswordChange()` – Groß-/Kleinschreibung + unvollständiger Satz**
  - Datei/Zeile: `src/Util/Translator/German.php:120`
  - Ist: `'Du hast dein Passwort lange nicht geändert. Das letzte mal ' . …`
  - Probleme:
    - `mal` (Substantiv) → `Mal`
    - Satz endet offen; EN hat vollen Satz `'The last time was …'`
  - Vorschlag Soll: `'Du hast dein Passwort lange nicht geändert. Das letzte Mal war am ' . … . '.'`

- [ ] **1.4 `German.php::welcomeUser()` – doppeltes Leerzeichen**
  - Datei/Zeile: `src/Util/Translator/German.php:1141`
  - Ist: `'Willkommen,  ' . $useName . '!'`
  - Soll: `'Willkommen, ' . $useName . '!'`

- [ ] **1.5 `English.php::dashboardChangePassword()` – Kontext passt nicht**
  - DE ist Hinweistext (`'Du solltest dein Passwort ändern.'`), EN ist Button-Label (`'change password'`).
  - Soll (EN): `'You should change your password.'`

---

## 2. „Intervall“ falsch geschrieben (DE)

Im Deutschen mit doppel-L.

- [ ] **2.1 `German.php::intervalType()`** – Ist: `'Interval-Typ'` → Soll: `'Intervall-Typ'`
- [ ] **2.2 `German.php::intervalValue()`** – Ist: `'Interval-Wert'` → Soll: `'Intervall-Wert'`
- [ ] **2.3 `German.php::backupDelay()`** – Ist: `'Backup-Interval …'` → Soll: `'Backup-Intervall …'`
- (bereits korrekt: `intervalMode()` = `'Intervall-Modus'`)

---

## 3. Fehlende Übersetzungen (DE hat noch EN drin)

- [ ] **3.1 `German.php::reset()`** – Ist: `'reset'` → Soll: `'zurücksetzen'` (vgl. `taskReset()` = „Aufgabe zurückgesetzt.“)
- [ ] **3.2 `German.php::log()`** – Ist: `'log'` → Soll: `'Protokoll'` (oder `'Log'`, aber dann konsistent Substantiv-Großschreibung)
- [ ] **3.3 `German.php::timerReset()`** – Ist: `'Neu'` → Soll: `'Zurücksetzen'`
  - Grund: `new()` ist bereits `'neu'`; `'Neu'` für Reset ist semantisch irreführend.

---

## 4. Konsistenz EN ↔ DE

- [ ] **4.1 Terminologie `bee` vs. `worker` (EN)**
  - DE nutzt durchgehend „Biene(n)“/„fleißige(s) Bienchen“.
  - EN gemischt: `bee`/`bees` in `worker()`/`workers()`, aber `worker not found`, `add new worker`, `work log for …`.
  - **Entscheidung nötig [?]**: EN überall auf `bee(s)` vereinheitlichen ODER DE auf „Worker/Arbeiter“?
  - Empfehlung: EN auf `bee(s)` angleichen, um die verspielte Terminologie beizubehalten.

- [ ] **4.2 `+2fa` / `-2fa` (DE) → `+2FA` / `-2FA`**
  - Datei: `German.php`, Methoden `addTwoFactor()` / `removeTwoFactor()`

- [ ] **4.3 `iAmWorkingOn()` (EN)** – Ist: `'i am working on it'` → Soll: `'I am working on it'`

- [ ] **4.4 `fillTimeLineQuestion()` (EN)** – Ist: `'do fill time line?'` → Soll: `'Fill time line?'`

- [ ] **4.5 EN Frage-Strings mit Kleinbuchstaben [?]**
  - `hasPasswordQuestion()` `'has password?'`, `isAdminQuestion()` `'is admin?'`, `hasPasskeyQuestion()` `'has passkey?'`
  - Vorschlag: `'Has password?'`, `'Is admin?'`, `'Has passkey?'`
  - Klärung: Sollen EN-Labels durchgehend lowercase bleiben (aktuelle Konvention) oder Fragen groß?

- [ ] **4.6 `intervalTypeCyclic()` [?]**
  - DE: `'hart zyklisch'`, EN: `'cyclic'`
  - Falls Unterschied zu „relativ zyklisch“ bedeutungstragend: EN → `'strictly cyclic'`. Sonst DE auf `'zyklisch'` kürzen.

---

## 5. Semantik-Klärung nötig [?]

- [ ] **5.1 `assignmentRemoved()` / `workerAssigned()` – „Markierung“ vs. „Zuweisung“**
  - `German.php`:
    - `workerAssigned()` = `'Markierung erfolgreich gesetzt'`
    - `assignmentRemoved()` = `'Markierung erfolgreich entfernt.'`
  - `English.php`:
    - `workerAssigned()` = `'worker assigned'`
    - `assignmentRemoved()` = `'removed assignment'`
  - **Frage an dich**: Ist das Feature eine echte Zuweisung (Biene ↔ Aufgabe) oder nur eine „ich mache das“-Markierung?
    - Wenn Zuweisung → DE anpassen: `'Biene zugewiesen.'` / `'Zuweisung entfernt.'`
    - Wenn Markierung → EN anpassen: `'marking set'` / `'marking removed'`

---

## 6. Kleinkram / Optional

- [ ] **6.1 `oneMinute()`…`fiveMinutes()`** – EN nutzt Ziffern (`'1 minute'`), DE Wörter (`'eine Minute'`). Für sich ok; angleichen nur falls UI-Kontext das verlangt. [?]
- [ ] **6.2 EN Groß-/Kleinschreibung [?]** – Mostly lowercase, aber `attention()` `'Attention!'`, `code()` `'Code'`, `codes()` `'Codes'`. Vereinheitlichen?

---

## Empfohlene Abarbeitungsreihenfolge

1. Abschnitt **1** (Bugs) – ohne Rückfragen umsetzbar.
2. Abschnitt **2** (Intervall) – ohne Rückfragen umsetzbar.
3. Abschnitt **3** (fehlende DE-Übersetzungen) – ohne Rückfragen umsetzbar.
4. Abschnitt **4.2 / 4.3 / 4.4** – ohne Rückfragen umsetzbar.
5. Klärung der `[?]`-Punkte (4.1, 4.5, 4.6, 5.1, 6.1, 6.2), dann umsetzen.

---

## Status-Log

- 2026-08-14: Review erstellt (initial). Noch keine Änderungen am Code.
