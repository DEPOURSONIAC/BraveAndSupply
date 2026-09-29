# BraveAndSupply — Flags

This file lists the security flags available in the project.

Each flag represents a specific vulnerability or security concept demonstrated in a controlled environment.

## Flags

### FLAG 01 — Brute Force

**Status:** Planned

Demonstrates how repeated login attempts can be used to discover a user's password when no effective rate limiting is present.

### FLAG 02 — Session / Cookie Theft

**Status:** Planned

Demonstrates the risks of session hijacking when an attacker obtains a user's session cookie.

---

## Flag Documentation

Each flag will eventually contain:

* The vulnerability
* The objective
* The vulnerable implementation
* The exploitation scenario
* The fix
* The security concepts involved

Detailed tutorials will be added directly to this file as the flags are implemented.


TEST:

                    BRAVEANDSUPPLY V2
                           │
                           ▼
                        LOGIN
                           │
                    [ FLAG 01 ]->FLAG{YOU_ARE_WHAT_YOUR_COOKIE/SESSIONS_SAYS}
                    Brute Force
                           │
                           ▼
                    COMPTE UTILISATEUR
                           │
                    [ FLAG 02 ]->FLAG{THE_SERVER_TRUSTS_WHAT_YOU_SEND}
                 Session / Cookie
                           │
                           ▼
                    AUTRE FONCTIONNALITÉ
                           │
                    [ FLAG 03 ]
                         RCE->FLAG{WE_SELL_RUM_ILLEGALLY_IN_AmiralDesMers}
                           │
                           ▼
                     COMPTE ADMIN
                           │
                           ▼
                  [ FLAG FINAL ]
                  AMIRAL DES MERS
                           │
                           ▼
                       CTF EVENT N°03