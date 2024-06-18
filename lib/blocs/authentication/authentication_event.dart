import '../../repositories/authentication_repository.dart';

abstract class AuthenticationEvent {
  const AuthenticationEvent();
}

final class AuthenticationStatusChanged extends AuthenticationEvent {
  const AuthenticationStatusChanged(this.status);

  final AuthenticationStatus status;
}

final class AuthenticationLogoutRequested extends AuthenticationEvent {}

//code cũ
class AuthenticationLoginRequested extends AuthenticationEvent {
  final String id;
  final String password;

  AuthenticationLoginRequested({required this.id, required this.password});
}

class AuthenticationLoginEmailRequested extends AuthenticationEvent {
  final String email;
  final String password;

  AuthenticationLoginEmailRequested({required this.email, required this.password});
}
