#!/bin/bash
sort -rk2n ./upload/doc.sql | awk '{if ($0!=line) print;line=$0}' >> ./upload/resort_doc.sql
sort -rk2n ./upload/profile.sql | awk '{if ($0!=line) print;line=$0}' >> ./upload/resort_profile.sql
sort -rk2n ./upload/relation.sql | awk '{if ($0!=line) print;line=$0}' >> ./upload/resort_relation.sql

