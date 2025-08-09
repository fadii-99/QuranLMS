#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🛑 Stopping Quran LMS Smart Classroom System${NC}"
echo -e "${BLUE}=============================================${NC}"

# Stop Laravel server
echo -e "${YELLOW}🛑 Stopping Laravel server...${NC}"
pkill -f "php artisan serve" 2>/dev/null && echo -e "${GREEN}✅ Laravel server stopped${NC}" || echo -e "${YELLOW}⚠️  Laravel server was not running${NC}"

# Stop Python API server
echo -e "${YELLOW}🛑 Stopping Python API server...${NC}"
pkill -f "classroom_api_server.py" 2>/dev/null && echo -e "${GREEN}✅ Python API server stopped${NC}" || echo -e "${YELLOW}⚠️  Python API server was not running${NC}"
pkill -f "uvicorn" 2>/dev/null

# Clean up PID files
rm -f python_server.pid laravel_server.pid 2>/dev/null

echo -e "${GREEN}🎉 All servers stopped successfully!${NC}"
