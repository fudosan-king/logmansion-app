abstract class AuthenticationEvent {}

class AuthenticationLoginRequested extends AuthenticationEvent {
  final String email;
  final String password;

  AuthenticationLoginRequested({required this.email, required this.password});
}
