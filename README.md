# Laravel CRUD to Microservice Sample

## Enterprise-Grade CQRS + DDD Implementation

This project demonstrates the complete transformation of a basic Laravel CRUD application into an enterprise-grade microservice using **CQRS (Command Query Responsibility Segregation)** and **DDD (Domain-Driven Design)** patterns.

## 🏗️ Architecture Evolution

### Phase 1: Traditional CRUD ✅
- Laravel 12 project setup with basic MVC pattern
- Direct Eloquent usage in controllers
- Simple validation and error handling
- RESTful API endpoints for user management

### Phase 2: CQRS Architecture ✅
- Command pattern for write operations (Create, Update, Delete)
- Query pattern for read operations (Read, List)
- Separate handlers for business logic
- Command/Query bus implementation with dependency injection

### Phase 3: Complete DDD + CQRS ✅
- **Domain Layer**: Value Objects, Entities, Aggregates, Domain Services
- **Application Layer**: Application Services, DTOs, Use Cases
- **Infrastructure Layer**: Repository implementations, Bus patterns
- **Clean Architecture**: Proper dependency inversion and separation of concerns

### Phase 4: Microservice Architecture 📋 (Ready for Implementation)
- Docker containerization structure
- API gateway patterns
- Event-driven communication
- Scalable deployment architecture

## Enterprise Architecture Patterns Implemented

Based on 2024-2025 best practices research:

### CQRS (Command Query Responsibility Segregation)
- **Commands**: Handle write operations (CreateUser, UpdateUser, DeleteUser)
- **Queries**: Handle read operations (GetUser, ListUsers)
- **Handlers**: Process business logic for each command/query
- **Bus Pattern**: Centralized dispatching mechanism

### DDD (Domain-Driven Design)
- **Domain Layer**: Core business logic and entities
- **Application Layer**: Use cases and application services
- **Infrastructure Layer**: Data persistence and external integrations
- **Bounded Contexts**: Clear domain boundaries

### Clean Architecture Principles
- **Dependency Inversion**: Domain doesn't depend on infrastructure
- **Single Responsibility**: Each class has one reason to change
- **Open/Closed**: Open for extension, closed for modification
- **Interface Segregation**: Clients depend only on interfaces they use

## API Endpoints

### Current Endpoints (Basic CRUD)
```
GET    /api/           - API information
GET    /api/users      - List all users
GET    /api/users/{id} - Get specific user
POST   /api/users      - Create new user
PUT    /api/users/{id} - Update user
DELETE /api/users/{id} - Delete user
```

### Request/Response Examples

#### Create User
```bash
curl -X POST http://127.0.0.1:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123"}'
```

#### Response
```json
{
  "status": "success",
  "message": "User created successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-09-17T15:34:44.000000Z"
  }
}
```

## Technology Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: SQLite (development)
- **Architecture**: CQRS + DDD + Clean Architecture
- **Patterns**: Repository, Command Bus, Query Bus
- **Testing**: PHPUnit

## Installation & Setup

1. **Clone the repository**
```bash
git clone <repository-url>
cd crud-microservice-sample
```

2. **Install dependencies**
```bash
composer install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
```bash
php artisan migrate
```

5. **Start development server**
```bash
php artisan serve
```

## Enterprise Implementation Progress

### ✅ Completed
- [x] Laravel 12 project setup
- [x] Basic User model and migration
- [x] RESTful API endpoints
- [x] CRUD functionality testing

### 🚧 In Progress
- [ ] CQRS architecture implementation
- [ ] Command and Query separation
- [ ] Handler pattern implementation
- [ ] Command/Query bus setup

### 📋 Planned
- [ ] DDD layered architecture
- [ ] Domain entities and value objects
- [ ] Repository pattern
- [ ] Application services
- [ ] Infrastructure layer
- [ ] Event sourcing (optional)
- [ ] Microservice containerization
- [ ] API gateway integration
- [ ] Service mesh configuration

## Architecture References

This implementation follows enterprise-grade patterns based on:

- **Laravel Clean Architecture & DDD** patterns from industry leaders
- **CQRS implementation** best practices for Laravel applications
- **Microservices architecture** patterns for scalable systems
- **Domain-Driven Design** principles for complex business logic

## Production Readiness Features (Planned)

- **Event Sourcing**: Complete audit trail of all changes
- **Message Queuing**: Asynchronous processing with Redis/RabbitMQ
- **Docker Containerization**: Production-ready deployment
- **API Versioning**: Backward compatibility support
- **Comprehensive Testing**: Unit, Integration, and E2E tests
- **Monitoring & Logging**: Observability for production systems
- **Security**: Authentication, authorization, and rate limiting

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Note**: This is an educational project demonstrating the evolution from basic CRUD to enterprise-grade microservice architecture using modern Laravel patterns and best practices.