@echo off
echo Building assets...
call npm install
call npm run dev
echo Assets built successfully!
pause