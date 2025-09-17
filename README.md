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

## 🎯 Complete Enterprise Architecture Structure

### 📁 Domain Layer (Business Rules)
```
app/Domain/User/
├── ValueObjects/           # 🔹 Type-safe business values
│   ├── Email.php          # Email validation + business rules
│   ├── UserName.php       # Name validation + constraints  
│   ├── UserId.php         # Typed identifier
│   └── HashedPassword.php # Secure password handling
├── Entities/              # 🔹 Rich domain objects
│   └── UserEntity.php     # Core business logic
├── Aggregates/            # 🔹 Consistency boundaries
│   └── UserAggregate.php  # Domain events + invariants
├── Services/              # 🔹 Complex business rules
│   └── UserDomainService.php
├── Commands/              # 🔹 Write operations
│   ├── CreateUserCommand.php
│   ├── UpdateUserCommand.php
│   └── DeleteUserCommand.php
├── Queries/               # 🔹 Read operations
│   ├── GetUserQuery.php
│   └── ListUsersQuery.php
├── Handlers/              # 🔹 CQRS logic processors
│   ├── CreateUserCommandHandler.php
│   ├── UpdateUserCommandHandler.php
│   ├── DeleteUserCommandHandler.php
│   ├── GetUserQueryHandler.php
│   └── ListUsersQueryHandler.php
└── Contracts/             # 🔹 Domain interfaces
    ├── CommandInterface.php
    ├── QueryInterface.php
    └── UserRepositoryInterface.php
```

### 📁 Application Layer (Use Cases)
```
app/Application/
├── Services/              # 🔹 Application orchestration
│   └── UserApplicationService.php
└── DTOs/                  # 🔹 Data transfer objects
    ├── UserDTO.php
    ├── CreateUserDTO.php
    └── UpdateUserDTO.php
```

### 📁 Infrastructure Layer (Technical Details)
```
app/Infrastructure/
├── Repositories/          # 🔹 Data persistence
│   └── EloquentUserRepository.php
└── Bus/                   # 🔹 CQRS dispatching
    ├── CommandBus.php
    └── QueryBus.php
```

### 📁 Presentation Layer (API Interface)
```
app/Http/Controllers/
├── UserController.php     # v1 - Traditional CRUD
├── CQRSUserController.php # v2 - CQRS Pattern
└── DDDUserController.php  # v3 - Enterprise DDD
```

## 🏛️ Enterprise Patterns Implemented

### CQRS (Command Query Responsibility Segregation)
- **Commands**: Handle write operations with strong typing
- **Queries**: Handle read operations with optimized data access
- **Handlers**: Encapsulated business logic for each operation
- **Bus Pattern**: Centralized dispatching with dependency injection

### DDD (Domain-Driven Design)
- **Value Objects**: Immutable, self-validating business values
- **Entities**: Rich objects with identity and behavior
- **Aggregates**: Consistency boundaries with domain events
- **Domain Services**: Complex business rules that don't belong to entities
- **Bounded Contexts**: Clear separation of business domains

### Clean Architecture Principles
- **Dependency Inversion**: Domain doesn't depend on infrastructure
- **Single Responsibility**: Each class has one clear purpose
- **Open/Closed**: Open for extension, closed for modification
- **Interface Segregation**: Focused, minimal interfaces

## 🚀 API Endpoints - Three Architecture Approaches

### v1 - Traditional CRUD (Basic Laravel MVC)
```bash
GET    /api/users      # List all users (Traditional)
GET    /api/users/{id} # Get specific user (Traditional)
POST   /api/users      # Create new user (Traditional)
PUT    /api/users/{id} # Update user (Traditional)
DELETE /api/users/{id} # Delete user (Traditional)
```

### v2 - CQRS Pattern (Command/Query Separation)
```bash
GET    /api/v2/users      # List all users (CQRS)
GET    /api/v2/users/{id} # Get specific user (CQRS)
POST   /api/v2/users      # Create new user (CQRS)
PUT    /api/v2/users/{id} # Update user (CQRS)
DELETE /api/v2/users/{id} # Delete user (CQRS)
```

### v3 - Enterprise DDD + CQRS (Complete Enterprise Architecture)
```bash
GET    /api/v3/users      # List all users (Enterprise DDD)
GET    /api/v3/users/{id} # Get specific user (Enterprise DDD)
POST   /api/v3/users      # Create new user (Enterprise DDD)
PUT    /api/v3/users/{id} # Update user (Enterprise DDD)
DELETE /api/v3/users/{id} # Delete user (Enterprise DDD)
```

## 📝 Request/Response Examples

### Creating a User (v3 - Enterprise)
```bash
curl -X POST http://127.0.0.1:8000/api/v3/users \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Enterprise Response with Domain Validation
```json
{
  "status": "success",
  "message": "User created successfully with DDD architecture",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-09-17T15:34:44.000000Z",
    "updated_at": "2025-09-17T15:34:44.000000Z"
  }
}
```

### Error Response with Domain Validation
```json
{
  "status": "error",
  "message": "Domain validation failed",
  "error": "Validation failed: {\"email\":[\"Email address is already taken\"]}"
}
```

## 💻 Technology Stack

- **Framework**: Laravel 12 (Latest)
- **PHP**: 8.2+ (Modern PHP features)
- **Database**: SQLite (Development) / MySQL (Production ready)
- **Architecture**: Clean Architecture + DDD + CQRS
- **Design Patterns**: 
  - Repository Pattern
  - Command Bus Pattern
  - Query Bus Pattern
  - Aggregate Pattern
  - Value Object Pattern
  - DTO Pattern
  - Service Layer Pattern
- **Testing**: PHPUnit (Unit + Integration tests ready)
- **Validation**: Domain-level validation with Value Objects
- **Event Sourcing**: Ready for implementation
- **Dependency Injection**: Laravel Container + Service Providers

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

## ✅ Enterprise Implementation Status

### 🎯 Phase 1: Traditional CRUD (Completed)
- [x] Laravel 12 project setup with modern PHP 8.2+ features
- [x] User model and migration with proper database schema
- [x] Traditional MVC controller implementation
- [x] RESTful API endpoints with validation
- [x] Basic CRUD functionality testing

### 🎯 Phase 2: CQRS Architecture (Completed)
- [x] Command pattern implementation (Create, Update, Delete)
- [x] Query pattern implementation (Get, List)
- [x] Handler pattern with business logic separation
- [x] Command/Query bus setup with dependency injection
- [x] Repository pattern with interface abstraction

### 🎯 Phase 3: Complete DDD + CQRS (Completed)
- [x] **Domain Layer**:
  - [x] Value Objects (Email, UserName, UserId, HashedPassword)
  - [x] Rich Domain Entities (UserEntity)
  - [x] Aggregate Roots (UserAggregate) with domain events
  - [x] Domain Services (UserDomainService) for complex business rules
- [x] **Application Layer**:
  - [x] Application Services (UserApplicationService)
  - [x] Data Transfer Objects (DTOs)
  - [x] Use case orchestration
- [x] **Infrastructure Layer**:
  - [x] Repository implementations (EloquentUserRepository)
  - [x] CQRS Bus implementations
  - [x] Service provider registration
- [x] **Presentation Layer**:
  - [x] Enterprise-grade controllers with proper error handling
  - [x] Domain validation integration
  - [x] Clean API responses

### 🚀 Phase 4: Microservice Architecture (Ready for Implementation)
- [ ] Docker containerization with multi-stage builds
- [ ] API Gateway pattern implementation
- [ ] Event-driven communication with message queues
- [ ] Service mesh configuration (Istio/Linkerd)
- [ ] Kubernetes deployment manifests
- [ ] Monitoring and observability (Prometheus/Grafana)
- [ ] Circuit breaker patterns
- [ ] Distributed tracing

## 🏆 Enterprise Features Implemented

### 🔒 Domain-Level Security
- **Value Object Validation**: Email format, password strength, name constraints
- **Type Safety**: Strongly typed identifiers and business values
- **Immutable Objects**: Value objects prevent accidental mutations
- **Domain Invariants**: Business rules enforced at the aggregate level

### 🎯 CQRS Benefits Realized
- **Read/Write Optimization**: Separate optimized paths for queries and commands
- **Scalability**: Independent scaling of read and write operations
- **Maintainability**: Clear separation of concerns
- **Testability**: Isolated handlers for focused unit testing

### 📐 Clean Architecture Benefits
- **Independence**: Domain logic independent of frameworks and databases
- **Testability**: Easy to test business logic without external dependencies
- **Flexibility**: Can swap infrastructure components without changing business rules
- **Maintainability**: Clear boundaries and responsibilities

### 🚀 Production-Ready Features

#### ✅ Currently Implemented
- **Domain Events**: Aggregate-level event recording (ready for event sourcing)
- **Repository Pattern**: Database abstraction for easy testing and swapping
- **Service Layer**: Clear separation of application and domain logic
- **DTO Pattern**: Type-safe data transfer between layers
- **Dependency Injection**: Proper IoC container usage
- **Error Handling**: Enterprise-grade error responses with proper HTTP status codes

#### 🔮 Ready for Implementation
- **Event Sourcing**: Complete audit trail with event store
- **Message Queuing**: Asynchronous processing with Redis/RabbitMQ
- **Caching**: Redis-based caching for read operations
- **API Gateway**: Centralized routing and cross-cutting concerns
- **Rate Limiting**: Protection against abuse
- **Authentication/Authorization**: JWT-based security
- **Monitoring**: Application metrics and health checks
- **Logging**: Structured logging with correlation IDs

## 📚 Architecture References

This implementation follows enterprise-grade patterns based on **2024-2025 industry best practices**:

### 🏛️ Domain-Driven Design (DDD)
- **Eric Evans** - Domain-Driven Design: Tackling Complexity in the Heart of Software
- **Vaughn Vernon** - Implementing Domain-Driven Design
- **Scott Millett** - Patterns, Principles, and Practices of Domain-Driven Design

### ⚡ CQRS & Event Sourcing
- **Greg Young** - CQRS and Event Sourcing patterns
- **Udi Dahan** - Advanced distributed systems design
- **Martin Fowler** - CQRS pattern documentation

### 🏗️ Clean Architecture
- **Robert C. Martin** - Clean Architecture: A Craftsman's Guide
- **Hexagonal Architecture** by Alistair Cockburn
- **Onion Architecture** by Jeffrey Palermo

### 🐘 Laravel Enterprise Patterns
- **Laravel Clean Architecture** implementations for PHP 8.2+
- **Modern Laravel** best practices for enterprise applications
- **Microservices with Laravel** for scalable architectures

## 🧪 Testing the Implementation

### Test All Three Architecture Versions

1. **Start the Laravel server**:
```bash
php artisan serve
```

2. **Test Traditional CRUD (v1)**:
```bash
# Create user with traditional approach
curl -X POST http://127.0.0.1:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name":"John Traditional","email":"john.trad@example.com","password":"password123"}'

# List users
curl -X GET http://127.0.0.1:8000/api/users
```

3. **Test CQRS (v2)**:
```bash
# Create user with CQRS pattern
curl -X POST http://127.0.0.1:8000/api/v2/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Jane CQRS","email":"jane.cqrs@example.com","password":"password123"}'

# Get specific user
curl -X GET http://127.0.0.1:8000/api/v2/users/1
```

4. **Test Enterprise DDD (v3)**:
```bash
# Create user with full DDD architecture
curl -X POST http://127.0.0.1:8000/api/v3/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Bob Enterprise","email":"bob.enterprise@example.com","password":"password123"}'

# Update user with domain validation
curl -X PUT http://127.0.0.1:8000/api/v3/users/1 \
  -H "Content-Type: application/json" \
  -d '{"name":"Bob Updated"}'
```

5. **Test Domain Validation**:
```bash
# Try creating user with invalid email (should fail)
curl -X POST http://127.0.0.1:8000/api/v3/users \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"invalid-email","password":"123"}'
```

## 🎓 Learning Outcomes

By exploring this project, you'll understand:

### **Traditional MVC vs Modern Architecture**
- How basic Laravel CRUD works
- Why enterprise applications need more sophisticated patterns
- The evolution from simple to complex architecture

### **CQRS Implementation**
- Command/Query separation benefits
- Handler pattern for business logic
- Bus pattern for decoupling

### **Domain-Driven Design**
- Value Objects for type safety and validation
- Rich domain entities vs anemic models
- Aggregate patterns for consistency
- Domain services for complex business rules

### **Clean Architecture Principles**
- Dependency inversion in practice
- Layer separation and communication
- Infrastructure independence

### **Enterprise Development**
- Scalable code organization
- Maintainable architecture patterns
- Production-ready error handling
- Domain event integration

## 🏢 Production Deployment Considerations

### Performance Optimizations
- **Read/Write Separation**: CQRS enables separate database optimization
- **Caching Strategy**: Repository pattern facilitates cache integration
- **Query Optimization**: Separate query handlers for performance tuning

### Scalability Patterns
- **Microservice Ready**: Clear bounded contexts for service extraction
- **Event-Driven**: Domain events enable asynchronous processing
- **Database Partitioning**: Repository abstraction supports data sharding

### Monitoring & Observability
- **Domain Events**: Built-in audit trail and business intelligence
- **Handler Metrics**: CQRS handlers perfect for performance monitoring
- **Error Tracking**: Structured error handling with correlation IDs

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🌟 Conclusion

This project demonstrates a **complete architectural evolution** from basic CRUD to enterprise-grade microservice architecture using **Laravel 12** and **modern PHP 8.2+** features.

**Key Achievements:**
- ✅ **3 Progressive Architecture Implementations** (Traditional → CQRS → DDD)
- ✅ **Enterprise Design Patterns** (Value Objects, Aggregates, Domain Services)  
- ✅ **Production-Ready Code Structure** (Clean Architecture, SOLID principles)
- ✅ **Scalable Foundation** (Event sourcing ready, microservice prepared)

Perfect for developers looking to understand **modern Laravel enterprise development** and **domain-driven design** implementation in real-world applications.

**🚀 Ready for your next enterprise Laravel project!**