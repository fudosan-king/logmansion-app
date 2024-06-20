import 'package:equatable/equatable.dart';

import '../../models/user.dart';
import '../../repositories/authentication_repository.dart';

class AuthenticationState extends Equatable {
  const AuthenticationState._({
    this.status = AuthenticationStatus.unknown,
    this.user = User.empty,
  });

  const AuthenticationState.unknown() : this._();

  const AuthenticationState.authenticated(User user)
      : this._(status: AuthenticationStatus.authenticated, user: user);

  const AuthenticationState.unauthenticated()
      : this._(status: AuthenticationStatus.unauthenticated);

  const AuthenticationState.firstUpdate(User user)
      : this._(status: AuthenticationStatus.firstLogin, user: user);

  final AuthenticationStatus status;
  final User user;

  @override
  List<Object> get props => [status, user];
}

// abstract class AuthenticationState {}
//
// class AuthenticationInitial extends AuthenticationState {}
//
// class AuthenticationLoading extends AuthenticationState {}
//
// class AuthenticationSuccess extends AuthenticationState {}
//
// class AuthenticationFailure extends AuthenticationState {
//   final String error;
//
//   AuthenticationFailure({required this.error});
// }
