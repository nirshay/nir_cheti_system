# DIRECTOR MASTER — FULL SYSTEM (UNIFIED)
DATE: 2026-03-19

========================================
1. PURPOSE
========================================
Single source of truth for:
- System understanding
- Base prompt generation
- Architecture integrity

========================================
2. SYSTEM STATUS
========================================
FINAL LOCK — PRODUCTION READY

========================================
3. USER FLOW
========================================
Editor → State → Schema → Resolver → Render → ClipPlan → Outputs

========================================
4. SYSTEM MAP
========================================
UI → State → CORE ENGINE → EXPORTS

CORE ENGINE:
- sceneSchema
- getEffectiveValue
- getSceneDuration
- buildClipPlan
- renderScene

========================================
5. DIAGNOSTICS SUMMARY
========================================
UI: Stable (minor chip inconsistencies)
ENGINE: Hardened (previous fragility resolved)
EXPORT: Unified (PDF aligned)

========================================
6. SSOT
========================================
renderScene
buildClipPlan
getEffectiveValue
getSceneDuration
sceneSchema
fieldTranslations
engineLabels

========================================
7. RULES
========================================
- No duplication
- No inline logic
- Auto = orange
- Manual = black
- Always use migration
- User text unchanged

========================================
8. EXCEPTIONS
========================================
- lensPosition bypass
- Lens auto = empty state
- Reserved settings fields

========================================
9. INTENTIONAL
========================================
- No auto translation
- Engines may infer

========================================
10. RISKS (ACCEPTED)
========================================
- Hebrew in English prompts
- index key UI issue

========================================
11. PROMPT STRATEGY
========================================
- Use SSOT only
- No behavior changes
- Surgical edits
- No duplication

========================================
12. FINAL
========================================
SYSTEM READY FOR SCALE
